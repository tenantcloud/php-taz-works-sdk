<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use GoodPhp\Serialization\MissingValue;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\UseDefaultForUnexpected;

class OrderDTO
{
	public function __construct(
		#[SerializedName('orderGuid')]
		public readonly string $id,
		#[SerializedName('orderStatus')]
		#[UseDefaultForUnexpected]
		public readonly ?OrderStatus $status = null,
		public readonly ?string $externalIdentifier = null,
		#[SerializedName('applicantGuid')]
		public readonly string|MissingValue $applicantId = MissingValue::INSTANCE,
		#[SerializedName('clientProductGuid')]
		public readonly string|MissingValue $clientProductId = MissingValue::INSTANCE,
	) {}
}
