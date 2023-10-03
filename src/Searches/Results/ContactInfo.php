<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use Crell\Serde\Attributes\ClassSettings;
use Crell\Serde\Attributes\SequenceField;

#[ClassSettings(requireValues: true)]
final class ContactInfo
{
	public function __construct(
		/** @var string[] */
		#[SequenceField(arrayType: 'string')]
		public readonly array $phoneNumbers = [],
		public readonly ?string $faxNumber = null,
		public readonly ?string $email = null,
	)
	{
	}
}
