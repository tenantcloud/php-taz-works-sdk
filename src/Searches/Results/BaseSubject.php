<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Carbon\CarbonImmutable;

final class BaseSubject
{
	public function __construct(
		public readonly ?string $fullName = null,
		public readonly ?string $firstName = null,
		public readonly ?string $middleName = null,
		public readonly ?string $lastName = null,
		public readonly ?string $ssn = null,
		public readonly ?CarbonImmutable $dateOfBirth = null,
		public readonly ?string $age = null,
	) {}
}
