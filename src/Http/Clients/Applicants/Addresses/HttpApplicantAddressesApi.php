<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Applicants\Addresses;

use GoodPhp\Reflection\Type\PrimitiveType;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressesApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\UpsertAddressDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use Webmozart\Assert\Assert;

class HttpApplicantAddressesApi implements AddressesApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	) {}

	public function list(string $applicantId): array
	{
		/** @var AddressDTO[] */
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'GET',
			url: "applicants/{$applicantId}/addresses",
			requestData: null,
			responseType: PrimitiveType::array(AddressDTO::class),
		);
	}

	public function create(string $applicantId, UpsertAddressDTO $data): AddressDTO
	{
		Assert::null($data->id);

		/** @var AddressDTO */
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'POST',
			url: "applicants/{$applicantId}/addresses",
			requestData: $data,
			responseType: AddressDTO::class,
		);
	}
}
