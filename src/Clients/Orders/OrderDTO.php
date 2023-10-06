<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use Crell\Serde\Attributes\Field;

class OrderDTO
{
	public function __construct(
		#[Field(serializedName: 'orderGuid')]
		public readonly string      $id,
		public readonly OrderStatus $orderStatus,
		public readonly ?string     $externalIdentifier = null,
	)
	{
	}
}
