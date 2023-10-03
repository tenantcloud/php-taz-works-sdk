<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;

interface OrdersApi
{
	public function searches(): OrderSearchesApi;

	public function submit(SubmitOrderDTO $data): OrderDTO;
}
