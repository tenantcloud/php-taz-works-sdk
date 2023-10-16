<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use Crell\Serde\Attributes\Field;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Http\Serialization\ForUnknownUseNull;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

class OrderSearchDTO
{
	public function __construct(
		#[Field(serializedName: 'orderSearchGuid')]
		public readonly string $id,
		#[ForUnknownUseNull]
		public readonly ?OrderSearchStatus $status = null,
		public readonly SearchResultType $type,
		public readonly string $displayName,
	)
	{
	}
}
