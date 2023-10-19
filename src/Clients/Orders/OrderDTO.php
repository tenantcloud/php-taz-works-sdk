<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\UseDefaultForUnexpected;

class OrderDTO
{
	public function __construct(
		#[SerializedName('orderGuid')]
		public readonly string      $id,
		#[SerializedName('orderStatus')]
		#[UseDefaultForUnexpected]
		public readonly ?OrderStatus $status = null,
		public readonly ?string     $externalIdentifier = null,
	)
	{
	}
}
