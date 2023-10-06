<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use Crell\Serde\Attributes\Field;

class OrderDTO
{
	public function __construct(
		#[Field(serializedName: 'orderGuid')]
		public readonly string      $id,
		#[Field(serializedName: 'orderStatus')]
		public readonly OrderStatus $status,
		public readonly ?string     $externalIdentifier = null,
	)
	{
	}
}
