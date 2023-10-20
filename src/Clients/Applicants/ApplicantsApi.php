<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressesApi;

interface ApplicantsApi
{
	public function addresses(): AddressesApi;
	public function find(string $id): ApplicantDTO;

	public function create(UpsertApplicantDTO $data): ApplicantDTO;
	public function update(string $id, UpsertApplicantDTO $data): ApplicantDTO;
}
