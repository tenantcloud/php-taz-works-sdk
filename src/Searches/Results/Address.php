<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

final class Address
{
	public function __construct(
		public readonly ?string $streetOne = null,
		public readonly ?string $streetTwo = null,
		public readonly ?string $city = null,
		public readonly ?string $stateOrProvince = null,
		public readonly ?string $postalCode = null,
		public readonly ?string $county = null,
		public readonly ?string $country = null,
		public readonly ?string $startDate = null,
		public readonly ?string $endDate = null,
	) {}
}
