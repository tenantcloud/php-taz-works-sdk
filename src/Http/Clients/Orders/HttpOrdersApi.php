<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Orders;

use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\Clients\Orders\Searches\HttpOrderSearchesApi;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;

class HttpOrdersApi implements OrdersApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	)
	{
	}

	public function searches(): OrderSearchesApi
	{
		return new HttpOrderSearchesApi($this->httpTazWorksClient);
	}

	public function submit(SubmitOrderDTO $data): OrderDTO
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'POST',
			url: 'orders',
			requestData: $data,
			responseDataClass: OrderDTO::class,
		);
	}
}
