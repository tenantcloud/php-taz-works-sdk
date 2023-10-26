<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Carbon\CarbonImmutable;

final class DispositionInfo
{
	public function __construct(
		public readonly ?string $disposition = null,
		public readonly ?CarbonImmutable $date = null,
		public readonly ?string $description = null,
		/** @var array<string, string> */
		public readonly array $other = [],
	) {}
}
