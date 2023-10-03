<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\DictionaryField;
use Crell\Serde\KeyType;

#[ClassSettings(requireValues: true)]
final class DispositionInfo
{
	public function __construct(
		public readonly ?string $disposition = null,
		public readonly ?CarbonImmutable $date = null,
		public readonly ?string $description = null,
		/** @var array<string, string> */
		#[DictionaryField(arrayType: 'string', keyType: KeyType::String)]
		public readonly array $other = [],
	)
	{
	}
}
