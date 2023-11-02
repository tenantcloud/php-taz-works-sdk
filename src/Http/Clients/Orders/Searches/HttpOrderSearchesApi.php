<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Orders\Searches;

use GoodPhp\Reflection\Type\PrimitiveType;
use GoodPhp\Serialization\TypeAdapter\Json\JsonTypeAdapter;
use GoodPhp\Serialization\TypeAdapter\Primitive\PrimitiveTypeAdapter;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchWithResultsDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias\NationalCriminalResult;

class HttpOrderSearchesApi implements OrderSearchesApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	) {}

	public function list(string $orderId): array
	{
		/** @var OrderSearchDTO[] */
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "orders/{$orderId}/searches",
			requestData: null,
			responseType: PrimitiveType::array(OrderSearchDTO::class),
		);
	}

	public function results(string $orderId, string $orderSearchId): OrderSearchWithResultsDTO
	{
		$response = $this->httpTazWorksClient->httpClient->request('GET', "orders/{$orderId}/searches/{$orderSearchId}/results");
		$responseBody = (string) $response->getBody();

		/** @var OrderSearchDTO $basicDto */
		$basicDto = $this->httpTazWorksClient->serializer
			->adapter(JsonTypeAdapter::class, OrderSearchDTO::class)
			->deserialize($responseBody);

		/** @var array{ results: mixed } $arrayResponseBody */
		$arrayResponseBody = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

		/** @var CriminalResult|NationalCriminalResult|null $resultsDto */
		$resultsDto = $this->httpTazWorksClient->serializer
			->adapter(PrimitiveTypeAdapter::class, $basicDto->type->className())
			->deserialize($arrayResponseBody['results']);

		return new OrderSearchWithResultsDTO(
			search: $basicDto,
			results: $resultsDto,
		);
	}
}
