<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients\Applicants;

use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressesApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Fake\Clients\Applicants\Addresses\FakeApplicantAddressesApi;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\NotFoundException;

class FakeApplicantsApi implements ApplicantsApi
{
	public function __construct(
		private readonly FakeTazWorksClient $tazWorksClient,
		private readonly string $clientId,
	) {}

	public function addresses(): AddressesApi
	{
		return new FakeApplicantAddressesApi($this->tazWorksClient, $this->clientId);
	}

	public function find(string $id): ApplicantDTO
	{
		/** @var ApplicantDTO */
		return $this->tazWorksClient->cache->get($this->applicantKey($id)) ?? throw new NotFoundException();
	}

	public function create(UpsertApplicantDTO $data): ApplicantDTO
	{
		$applicant = $this->applicantFromUpsert(Str::uuid()->toString(), $data);

		$this->tazWorksClient->cache->set($this->applicantKey($applicant), $applicant);

		return $applicant;
	}

	public function update(string $id, UpsertApplicantDTO $data): ApplicantDTO
	{
		if (!$this->tazWorksClient->cache->has($this->applicantKey($id))) {
			throw new NotFoundException();
		}

		$applicant = $this->applicantFromUpsert($id, $data);

		$this->tazWorksClient->cache->set($this->applicantKey($applicant), $applicant);

		return $applicant;
	}

	private function applicantFromUpsert(string $id, UpsertApplicantDTO $data): ApplicantDTO
	{
		return new ApplicantDTO(
			id: $id,
			firstName: $data->firstName,
			middleName: $data->middleName,
			lastName: $data->lastName,
			email: $data->email,
			ssn: $data->ssn,
		);
	}

	private function applicantKey(string|ApplicantDTO $id): string
	{
		$id = $id instanceof ApplicantDTO ? $id->id : $id;

		return "clients.{$this->clientId}.applicants.{$id}";
	}
}
