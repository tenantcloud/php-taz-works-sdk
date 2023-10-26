<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord;

use Carbon\CarbonImmutable;

final class Incarceration
{
	public function __construct(
		public readonly ?CarbonImmutable $releaseDate = null,
		public readonly ?string $custodialAgency = null,
		public readonly ?CarbonImmutable $incarcerationDate = null,
		public readonly ?string $sentenceLength = null,
		public readonly ?CarbonImmutable $tentativeReleaseDate = null,
		public readonly ?string $comments = null,
	) {}
}
