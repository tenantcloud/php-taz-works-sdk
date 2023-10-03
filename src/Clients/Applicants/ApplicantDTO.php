<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

use Crell\Serde\Attributes\Field;

class ApplicantDTO
{
	public function __construct(
		#[Field(serializedName: 'applicantGuid')]
		public readonly string $id,
		public readonly string $firstName,
		public readonly string $lastName,
		public readonly string $email,
	)
	{
	}
}
