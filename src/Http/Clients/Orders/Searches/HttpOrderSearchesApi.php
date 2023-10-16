<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Orders\Searches;

use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchWithResultsDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;

class HttpOrderSearchesApi implements OrderSearchesApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	)
	{
	}

	public function list(string $orderId): array
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "orders/$orderId/searches",
			requestData: null,
			responseDataClass: OrderSearchDTO::class,
			responseArray: true,
		);
	}

	public function results(string $orderId, string $orderSearchId): OrderSearchWithResultsDTO
	{
		$response = $this->httpTazWorksClient->httpClient->request('GET', "orders/$orderId/searches/$orderSearchId/results");
		$responseBody = (string) $response->getBody();

		/** @var OrderSearchDTO $basicDto */
		$basicDto = $this->httpTazWorksClient->serializer->deserialize($responseBody, from: 'json', to: OrderSearchDTO::class);

		$arrayResponseBody = json_decode($responseBody, true, 512, JSON_THROW_ON_ERROR);

		$resultsDto = $this->httpTazWorksClient->serializer->deserialize($arrayResponseBody['results'], from: 'array', to: $basicDto->type->className());

		return new OrderSearchWithResultsDTO(
			search: $basicDto,
			results: $resultsDto,
		);
	}
}
