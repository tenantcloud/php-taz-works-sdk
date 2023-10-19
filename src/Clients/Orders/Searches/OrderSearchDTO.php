<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\UseDefaultForUnexpected;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

class OrderSearchDTO
{
	public function __construct(
		#[SerializedName('orderSearchGuid')]
		public readonly string $id,
		public readonly SearchResultType $type,
		public readonly string $displayName,
		#[UseDefaultForUnexpected]
		public readonly ?OrderSearchStatus $status = null,
	)
	{
	}
}
