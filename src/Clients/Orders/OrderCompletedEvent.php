<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

class OrderCompletedEvent
{
	public function __construct(
		public readonly string $id,
	)
	{
	}
}
