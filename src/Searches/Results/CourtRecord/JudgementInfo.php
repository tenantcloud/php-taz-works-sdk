<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CourtRecord;

use Carbon\CarbonImmutable;

final class JudgementInfo
{
	public function __construct(
		public readonly ?CarbonImmutable $date = null,
		public readonly ?string $judgementFor = null,
		public readonly ?string $amount = null,
		public readonly ?string $flag = null,
	) {}
}
