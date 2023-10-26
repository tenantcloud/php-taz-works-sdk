<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

class OrderSubmittedEvent
{
	public function __construct(
		public readonly OrderDTO $order,
		public readonly string $clientId,
	) {}
}
