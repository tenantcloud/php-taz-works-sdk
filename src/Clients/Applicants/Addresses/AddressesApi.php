<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants\Addresses;

interface AddressesApi
{
	/**
	 * @return AddressDTO[]
	 */
	public function list(string $applicantId): array;

	public function create(string $applicantId, UpsertAddressDTO $data): AddressDTO;
}
