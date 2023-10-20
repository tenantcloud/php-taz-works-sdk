<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants\Addresses;

use Carbon\CarbonImmutable;
use GoodPhp\Serialization\TypeAdapter\Primitive\BuiltIn\Date;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use TenantCloud\TazWorksSDK\TazAssert;

class AddressDTO
{
	public function __construct(
		#[SerializedName('addressGuid')]
		public readonly string $id,
		#[SerializedName('addressType')]
		public readonly AddressType              $type,
		public readonly ?string              $streetOne,
		public readonly ?string              $streetTwo,
		public readonly ?string              $city,
		public readonly ?string              $stateOrProvince,
		public readonly ?string              $postalCode,
		public readonly ?string              $country,
	)
	{
	}
}
