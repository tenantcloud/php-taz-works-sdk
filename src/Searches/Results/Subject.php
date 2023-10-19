<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;

final class Subject
{
	public function __construct(
		#[Flatten]
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
		public readonly array $addresses = [],
		/** @var Alias[] */
		public readonly array $aliases = [],
		public readonly ?ContactInfo $contactInfo = null,
	)
	{
	}
}
