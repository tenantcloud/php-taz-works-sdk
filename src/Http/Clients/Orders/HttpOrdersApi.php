<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Orders;

use Carbon\CarbonInterval;
use Illuminate\Queue\SyncQueue;
use Psr\EventDispatcher\EventDispatcherInterface;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderSubmittedEvent;
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

	public function find(string $id): OrderDTO
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "orders/{$id}",
			requestData: null,
			responseDataClass: OrderDTO::class,
		);
	}

	public function submit(SubmitOrderDTO $data): OrderDTO
	{
		$order = $this->httpTazWorksClient->performJsonRequest(
			method: 'POST',
			url: 'orders',
			requestData: $data,
			responseDataClass: OrderDTO::class,
		);

		$this->httpTazWorksClient->events?->dispatch(new OrderSubmittedEvent($order));

		return $order;
	}
}
