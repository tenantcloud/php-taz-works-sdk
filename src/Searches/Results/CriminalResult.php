<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\SequenceField;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord;

/**
 * API type: COUNTY_CRIMINAL_RECORD
 */
#[ClassSettings(requireValues: true)]
final class CriminalResult
{
	public function __construct(
		public readonly ?string $jurisdictionsSearched = null,
		/** @var CriminalRecord[] */
		#[SequenceField(arrayType: CriminalRecord::class)]
		public readonly array $records = [],
	)
	{
	}
}
