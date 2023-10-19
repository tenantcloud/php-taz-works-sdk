<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Carbon\CarbonImmutable;
use TenantCloud\TazWorksSDK\Searches\Results\CourtRecord\JudgementInfo;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord;

final class CourtRecord
{
	public function __construct(
		public readonly ?Subject $subject = null,
		public readonly ?string $caseNumber = null,
		public readonly ?string $caseSequenceNumber = null,
		public readonly ?string $description = null,
		public readonly ?CarbonImmutable $date = null,
		public readonly ?string $uniqueId = null,
		public readonly ?string $status = null,
		public readonly ?string $courtCode = null,
		public readonly ?string $courtName = null,
		public readonly ?string $county = null,
		public readonly ?string $type = null,
		public readonly ?string $jurisdiction = null,
		public readonly ?string $provider = null,
		public readonly ?string $stateAbbreviation = null,
		public readonly ?CarbonImmutable $fileDate = null,
		public readonly ?string $comments = null,
		public readonly ?DispositionInfo $dispositionInfo = null,
		public readonly ?JudgementInfo $judgementInfo = null,
		/** @var DefendantPlaintiff[] */
		public readonly array $defendants = [],
		/** @var DefendantPlaintiff[] */
		public readonly array $plaintiffs = [],
	) {}
}
