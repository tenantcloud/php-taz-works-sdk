<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;

final class DefendantPlaintiff
{
	public function __construct(
		#[Flatten]
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
	) {}
}
