<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Orders\Searches;

use GoodPhp\Reflection\Type\PrimitiveType;
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
			responseType: PrimitiveType::array(OrderSearchDTO::class),
		);
	}

	public function results(string $orderId, string $orderSearchId): OrderSearchWithResultsDTO
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "orders/$orderId/searches/$orderSearchId/results",
			requestData: null,
			responseType: OrderSearchWithResultsDTO::class,
		);
	}
}
