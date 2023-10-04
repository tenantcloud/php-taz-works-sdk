<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

interface ApplicantsApi
{
	public function create(UpsertApplicantDTO $data): ApplicantDTO;
	public function update(string $id, UpsertApplicantDTO $data): ApplicantDTO;
}
