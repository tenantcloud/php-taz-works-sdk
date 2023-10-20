<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants\Addresses;

use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;

interface AddressesApi
{
	/**
	 * @return AddressDTO[]
	 */
	public function list(string $applicantId): array;
	public function create(string $applicantId, UpsertAddressDTO $data): AddressDTO;
}
