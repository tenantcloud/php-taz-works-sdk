<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients\Applicants\Addresses;

use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressesApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\UpsertAddressDTO;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\NotFoundException;

class FakeApplicantAddressesApi implements AddressesApi
{
	public function __construct(
		private readonly FakeTazWorksClient $tazWorksClient,
		private readonly string $clientId,
	) {}

	public function find(string $applicantId, string $addressId): AddressDTO
	{
		/** @var AddressDTO */
		return $this->tazWorksClient->cache->get($this->applicantAddressKey($applicantId, $addressId)) ?? throw new NotFoundException();
	}

	public function list(string $applicantId): array
	{
		/** @var array<int, string> $addressIds */
		$addressIds = $this->tazWorksClient->cache->get($this->applicantAddressesKey($applicantId));

		return array_map(fn (string $id) => $this->find($applicantId, $id), $addressIds);
	}

	public function create(string $applicantId, UpsertAddressDTO $data): AddressDTO
	{
		$address = new AddressDTO(
			id: Str::uuid()->toString(),
			type: $data->type,
			streetOne: $data->streetOne,
			streetTwo: $data->streetTwo,
			city: $data->city,
			stateOrProvince: $data->stateOrProvince,
			postalCode: $data->postalCode,
			country: $data->country,
		);

		$this->tazWorksClient->cache->set($this->applicantAddressKey($applicantId, $address), $address);

		/** @var string[] $ids */
		$ids = $this->tazWorksClient->cache->get($this->applicantAddressesKey($applicantId)) ?? [];
		$this->tazWorksClient->cache->set($this->applicantAddressesKey($applicantId), [...$ids, $address->id]);

		return $address;
	}

	private function applicantAddressKey(string $applicantId, string|AddressDTO $id): string
	{
		$id = $id instanceof AddressDTO ? $id->id : $id;

		return $this->applicantAddressesKey($applicantId) . ".{$id}";
	}

	private function applicantAddressesKey(string $applicantId): string
	{
		return "clients.{$this->clientId}.applicants.{$applicantId}.addresses";
	}
}
