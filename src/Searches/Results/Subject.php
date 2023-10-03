<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\Field;
use Crell\Serde\Attributes\SequenceField;

#[ClassSettings(requireValues: true)]
final class Subject
{
	public function __construct(
		#[Field(flatten: true)]
		public readonly ?BaseSubject $baseSubject = null,
		public readonly ?string $gender = null,
		public readonly ?string $race = null,
		public readonly ?string $height = null,
		public readonly ?string $weight = null,
		public readonly ?string $hairColor = null,
		public readonly ?string $eyeColor = null,
		public readonly ?string $imageUrl = null,
		public readonly ?string $stateUrl = null,
		/** @var Address[] */
		#[SequenceField(arrayType: Address::class)]
		public readonly ?array $addresses = null,
		/** @var Alias[] */
		#[SequenceField(arrayType: Alias::class)]
		public readonly ?array $aliases = null,
		public readonly ?ContactInfo $contactInfo = null,
	)
	{
	}
}
