<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use Crell\Serde\Attributes\Field;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

class OrderSearchDTO
{
	public function __construct(
		#[Field(serializedName: 'orderSearchGuid')]
		public readonly string $id,
		public readonly OrderStatus $status,
		public readonly SearchResultType $type,
	)
	{
	}
}
