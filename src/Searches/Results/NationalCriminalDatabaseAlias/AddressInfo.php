<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;
use TenantCloud\TazWorksSDK\Searches\Results\Subject;

final class AddressInfo
{
	public function __construct(
		#[Flatten]
		public readonly Subject $subject,
		public readonly ?string $verified = null,
		public readonly ?string $ageAtDeath = null,
		public readonly ?string $deathVerificationCode = null,
	) {}
}
