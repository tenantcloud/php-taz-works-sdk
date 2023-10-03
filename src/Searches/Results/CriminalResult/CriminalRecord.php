<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\Field;
use Crell\Serde\Attributes\SequenceField;
use TenantCloud\TazWorksSDK\Searches\Results\CourtRecord;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord\Incarceration;
use TenantCloud\TazWorksSDK\Searches\Results\DefendantPlaintiff;

#[ClassSettings(requireValues: true)]
final class CriminalRecord
{
	public function __construct(
		#[Field(flatten: true)]
		public readonly ?CourtRecord $courtRecord = null,
		/** @var Offense[] */
		#[SequenceField(arrayType: Offense::class)]
		public readonly array $offenses = [],
		public readonly ?Incarceration $incarceration = null,
		public readonly ?ProbationParole $probation = null,
		public readonly ?ProbationParole $parole = null,
	)
	{
	}
}
