<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;

class ApplicantDTO
{
	public function __construct(
		#[SerializedName('applicantGuid')]
		public readonly string $id,
		public readonly string $firstName,
		public readonly string $lastName,
		public readonly string $email,
		public readonly ?string $ssn = null,
	)
	{
	}
}
