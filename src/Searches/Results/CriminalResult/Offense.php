<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\DictionaryField;
use Crell\Serde\KeyType;
use TenantCloud\TazWorksSDK\Searches\Results\DispositionInfo;

#[ClassSettings(requireValues: true)]
final class Offense
{
	public function __construct(
		public readonly ?string $type = null,
		public readonly ?string $countOffense = null,
		public readonly ?SentenceInfo $sentenceInfo = null,
		public readonly ?DispositionInfo $dispositionInfo = null,
		public readonly ?string $caseNumber = null,
		public readonly ?CarbonImmutable $offenseDate = null,
		public readonly ?string $comments = null,
		public readonly ?string $custodialAgency = null,
		public readonly ?string $jurisdiction = null,
		public readonly ?string $description = null,
		public readonly ?string $probation = null,
		public readonly ?string $confinement = null,
		public readonly ?string $arrestingAgency = null,
		public readonly ?string $originatingAgency = null,
		public readonly ?string $statuteNumber = null,
		public readonly ?string $plea = null,
		public readonly ?string $courtDecision = null,
		public readonly ?string $courtCosts = null,
		public readonly ?string $court = null,
		public readonly ?string $fine = null,
		public readonly ?CarbonImmutable $arrestDate = null,
		public readonly ?CarbonImmutable $fileDate = null,
		/** @var array<string, string> */
		#[DictionaryField(arrayType: 'string', keyType: KeyType::String)]
		public readonly array $other = [],
	)
	{
	}
}
