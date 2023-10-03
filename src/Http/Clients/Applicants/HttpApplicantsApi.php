<?php

namespace TenantCloud\TazWorksSDK\Http\Clients\Applicants;

use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\Applicants\CreateApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;

class HttpApplicantsApi implements ApplicantsApi
{
	public function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
	)
	{
	}

	public function create(CreateApplicantDTO $data): ApplicantDTO
	{
		return $this->httpTazWorksClient->performJsonRequest(
			method: 'POST',
			url: 'applicants',
			requestData: $data,
			responseDataClass: ApplicantDTO::class,
		);
	}
}
