<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Carbon\CarbonImmutable;

final class Alias
{
	public function __construct(
		public readonly ?string $fullName = null,
		public readonly ?CarbonImmutable $dateOfBirth = null,
	)
	{
	}
}
