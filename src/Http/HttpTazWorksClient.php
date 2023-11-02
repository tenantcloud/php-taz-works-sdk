<?php

namespace TenantCloud\TazWorksSDK\Http;

use GoodPhp\Reflection\Type\Type;
use GoodPhp\Serialization\Serializer;
use GoodPhp\Serialization\TypeAdapter\Json\JsonTypeAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use TenantCloud\GuzzleHelper\DumpRequestBody\HeaderObfuscator;
use TenantCloud\GuzzleHelper\DumpRequestBody\JsonObfuscator;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\TazWorksSDK\Clients\ClientApi;
use TenantCloud\TazWorksSDK\Http\Clients\HttpClientApi;
use TenantCloud\TazWorksSDK\TazWorksClient;

/**
 * @internal
 */
class HttpTazWorksClient implements TazWorksClient
{
	/** todo: readonly in PHP 8.2 */
	public Client $httpClient;

	private readonly HandlerStack $handlerStack;

	/**
	 * @api
	 */
	public function __construct(
		private readonly string $baseUrl,
		string $apiToken,
		public readonly Serializer $serializer,
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
	 * @param Type|class-string $responseType
	 */
	public function performJsonRequest(string $method, string $url, ?object $requestData, string|Type $responseType): mixed
	{
		if ($requestData) {
			$serialized = $this->serializer
				->adapter(JsonTypeAdapter::class, $requestData::class)
				->serialize($requestData);
		}

		$response = $this->httpClient->request($method, $url, [
			'body'    => $serialized ?? null,
			'headers' => [
				'Content-Type' => 'application/json',
			],
		]);

		return $this->serializer
			->adapter(JsonTypeAdapter::class, $responseType)
			->deserialize((string) $response->getBody());
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
