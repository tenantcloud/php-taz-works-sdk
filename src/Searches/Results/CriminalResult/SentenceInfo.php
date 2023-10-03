<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\ClassSettings;

#[ClassSettings(requireValues: true)]
final class SentenceInfo
{
	public function __construct(
		public readonly ?string $sentence = null,
		public readonly ?CarbonImmutable $date = null,
		public readonly ?string $sentenceLength = null,
		public readonly ?string $type = null,
		public readonly ?string $description = null,
	)
	{
	}
}
