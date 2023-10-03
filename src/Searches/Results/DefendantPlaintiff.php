<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\Field;

#[ClassSettings(requireValues: true)]
final class DefendantPlaintiff
{
	public function __construct(
		#[Field(flatten: true)]
		public readonly ?BaseSubject $baseSubject = null,
		public readonly ?string $type = null,
		public readonly ?string $number = null,
		public readonly ?string $otherCaseNumber = null,
		public readonly ?string $aliasFlag = null,
		public readonly ?string $comments = null,
		public readonly ?string $description = null,
		public readonly ?string $attorneyName = null,
		public readonly ?string $attorneyPhone = null,
		public readonly ?string $spouseName = null,
	)
	{
	}
}
