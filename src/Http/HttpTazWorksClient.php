<?php

namespace TenantCloud\TazWorksSDK\Http;

use Crell\Serde\SerdeCommon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use TenantCloud\GuzzleHelper\DumpRequestBody\HeaderObfuscator;
use TenantCloud\GuzzleHelper\DumpRequestBody\JsonObfuscator;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\TazWorksSDK\Clients\ClientApi;
use TenantCloud\TazWorksSDK\Http\Clients\HttpClientApi;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\TazWorksClient;
use TenantCloud\TransUnionSDK\Reports\ReportNotReadyException;
use TenantCloud\TransUnionSDK\Reports\UserNotVerifiedException;
use TenantCloud\TransUnionSDK\Requests\Renters\CannotCancelRequestException;
use TenantCloud\TransUnionSDK\Shared\NotFoundException;
use function TenantCloud\GuzzleHelper\psr_response_to_json;

/**
 * @internal
 */
class HttpTazWorksClient implements TazWorksClient
{
	private readonly HandlerStack $handlerStack;
	/** todo: readonly in PHP 8.2 */
	public Client $httpClient;

	/**
	 * @api
	 */
	public function __construct(
		private readonly string $baseUrl,
		string $apiToken,
		public readonly SerdeCommon $serializer,
		public readonly ?EventDispatcherInterface $events = null,
		LoggerInterface $logger = null,
		private readonly int $timeout = 30,
	) {
		$this->handlerStack = $this->buildHandlerStack($apiToken, $logger);
		$this->httpClient = $this->buildHttpClient($baseUrl, $timeout, $this->handlerStack);
	}

	public function client(string $id): ClientApi
	{
		return HttpClientApi::fromClient($this, $id);
	}

	/**
	 * @internal
	 */
	public function withAddedUrlSuffix(string $url): self
	{
		$clone = clone $this;
		$clone->httpClient = $this->buildHttpClient($this->baseUrl . $url, $this->timeout, $this->handlerStack);

		return $clone;
	}

	/**
	 * @internal
	 *
	 * @template ResponseDataType of object
	 *
	 * @param class-string<ResponseDataType> $responseDataClass
	 *
	 * @return ($responseArray is true ? array<int, ResponseDataType> : ResponseDataType)
	 */
	public function performJsonRequest(string $method, string $url, ?object $requestData, string $responseDataClass, bool $responseArray = false): array|object
	{
		if ($requestData) {
			$serialized = $this->serializer->serialize($requestData, format: 'json');
		}

		$response = $this->httpClient->request($method, $url, [
			'body' => $serialized ?? null,
			'headers' => [
				'Content-Type' => 'application/json',
			]
		]);
		$responseBody = (string) $response->getBody();

		if ($responseArray) {
			return array_map(
				fn (mixed $data) => $this->serializer->deserialize($data, from: 'array', to: $responseDataClass),
				json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR)
			);
		}

		return $this->serializer->deserialize($responseBody, from: 'json', to: $responseDataClass);
	}

	private function buildHandlerStack(string $apiToken, ?LoggerInterface $logger): HandlerStack
	{
		$stack = HandlerStack::create();

		$stack->push(Middleware::mapRequest(
			static fn (RequestInterface $request) => $request
				->withHeader('Accept', 'application/json')
				->withHeader('Authorization', "Bearer {$apiToken}")
		));
		$stack->unshift(RethrowExceptionsMiddleware::make());
		$stack->unshift(GuzzleMiddleware::fullErrorResponseBody());
		$stack->unshift(GuzzleMiddleware::dumpRequestBody([
			new JsonObfuscator([
				'ssn',
				'email',
				'phoneNumber',
			]),
			new HeaderObfuscator(['Authorization']),
		]));

		if ($logger) {
			$stack->push(GuzzleMiddleware::tracingLog($logger));
		}

		return $stack;
	}

	private function buildHttpClient(string $baseUrl, int $timeout, HandlerStack $handlerStack): Client
	{
		return new Client([
			'base_uri'                      => $baseUrl,
			'handler'                       => $handlerStack,
			RequestOptions::CONNECT_TIMEOUT => $timeout,
			RequestOptions::TIMEOUT         => $timeout,
		]);
	}
}
