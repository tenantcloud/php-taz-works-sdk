<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Applicants;

use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressesApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\Clients\Applicants\Addresses\HttpApplicantAddressesApi;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use Webmozart\Assert\Assert;

class HttpApplicantsApi implements ApplicantsApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	)
	{
	}

	public function addresses(): AddressesApi
	{
		return new HttpApplicantAddressesApi($this->httpTazWorksClient);
	}

	public function find(string $id): ApplicantDTO
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "applicants/{$id}",
			requestData: null,
			responseType: ApplicantDTO::class,
		);
	}

	public function create(UpsertApplicantDTO $data): ApplicantDTO
	{
		Assert::null($data->id);

		return $this->httpTazWorksClient->performJsonRequest(
			method: 'POST',
			url: 'applicants',
			requestData: $data,
			responseType: ApplicantDTO::class,
		);
	}

	public function update(string $id, UpsertApplicantDTO $data): ApplicantDTO
	{
		$data->id = $id;

		return $this->httpTazWorksClient->performJsonRequest(
			method: 'PUT',
			url: "applicants/{$id}",
			requestData: $data,
			responseType: ApplicantDTO::class,
		);
	}
}
