<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

final class SsnInfo
{
	public function __construct(
		public readonly ?string $ssn = null,
		public readonly ?string $valid = null,
		public readonly ?string $issuedLocation = null,
		public readonly ?string $deceased = null,
		public readonly ?string $message = null,
		public readonly ?string $issuedDateRange = null,
		public readonly ?string $issuedStartDate = null,
		public readonly ?string $issuedEndDate = null,
	) {}
}
