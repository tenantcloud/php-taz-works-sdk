<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;

interface OrdersApi
{
	public function searches(): OrderSearchesApi;

	public function find(string $id): OrderDTO;

	public function submit(SubmitOrderDTO $data): OrderDTO;
}
