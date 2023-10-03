<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

interface ApplicantsApi
{
	public function create(CreateApplicantDTO $data): ApplicantDTO;
}
