<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants\Addresses;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;

class UpsertAddressDTO
{
	#[SerializedName('addressGuid')]
	public ?string $id = null;

	public function __construct(
		#[SerializedName('addressType')]
		public readonly AddressType $type,
		public readonly ?string $streetOne,
		public readonly ?string $streetTwo,
		public readonly ?string $city,
		public readonly ?string $stateOrProvince,
		public readonly ?string $postalCode,
		public readonly ?string $country,
	) {}
}
