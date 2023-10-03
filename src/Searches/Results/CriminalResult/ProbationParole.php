<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\ClassSettings;

#[ClassSettings(requireValues: true)]
final class ProbationParole
{
	public function __construct(
		public readonly ?CarbonImmutable $startDate = null,
		public readonly ?CarbonImmutable $actualEndDate = null,
		public readonly ?CarbonImmutable $scheduledEndDate = null,
		public readonly ?string $countyOfSupervision = null,
		public readonly ?string $length = null,
		public readonly ?string $comments = null,
	)
	{
	}
}
