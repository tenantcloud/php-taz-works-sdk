<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;
use TenantCloud\TazWorksSDK\Searches\Results\CourtRecord;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord\Incarceration;

final class CriminalRecord
{
	public function __construct(
		#[Flatten]
		public readonly ?CourtRecord $courtRecord = null,
		/** @var Offense[] */
		public readonly array $offenses = [],
		public readonly ?Incarceration $incarceration = null,
		public readonly ?ProbationParole $probation = null,
		public readonly ?ProbationParole $parole = null,
	) {}
}
