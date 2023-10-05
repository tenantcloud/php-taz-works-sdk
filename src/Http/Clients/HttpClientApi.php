<?php

namespace TenantCloud\TazWorksSDK\Http\Clients;

use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\ClientApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Http\Clients\Applicants\HttpApplicantsApi;
use TenantCloud\TazWorksSDK\Http\Clients\Orders\HttpOrdersApi;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;

class HttpClientApi implements ClientApi
{
	private function __construct(
		private readonly HttpTazWorksClient $httpTazWorksClient,
		private readonly string $clientId,
	)
	{
	}

	public static function fromClient(HttpTazWorksClient $httpTazWorksClient, string $clientId): self
	{
		return new self(
			$httpTazWorksClient->withAddedUrlSuffix("/v1/clients/{$clientId}/"),
			$clientId,
		);
	}

	public function applicants(): ApplicantsApi
	{
		return new HttpApplicantsApi($this->httpTazWorksClient);
	}

	public function orders(): OrdersApi
	{
		return new HttpOrdersApi($this->httpTazWorksClient);
	}
}
