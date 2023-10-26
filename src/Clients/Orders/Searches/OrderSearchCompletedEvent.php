<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

class OrderSearchCompletedEvent
{
	public function __construct(
		public readonly string $id,
		public readonly string $orderId,
	) {}
}
