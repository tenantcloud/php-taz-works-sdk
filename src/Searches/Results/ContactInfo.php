<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

final class ContactInfo
{
	public function __construct(
		/** @var string[] */
		public readonly array $phoneNumbers = [],
		public readonly ?string $faxNumber = null,
		public readonly ?string $email = null,
	)
	{
	}
}
