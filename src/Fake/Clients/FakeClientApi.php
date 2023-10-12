<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients;

use Illuminate\Contracts\Cache\Repository;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\ClientApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Fake\Clients\Applicants\FakeApplicantsApi;
use TenantCloud\TazWorksSDK\Fake\Clients\Orders\FakeOrdersApi;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;

class FakeClientApi implements ClientApi
{
	public function __construct(
		private readonly FakeTazWorksClient $tazWorksClient,
		private readonly string $clientId,
	) {}

	public function applicants(): ApplicantsApi
	{
		return new FakeApplicantsApi($this->tazWorksClient, $this->clientId);
	}

	public function orders(): OrdersApi
	{
		return new FakeOrdersApi($this->tazWorksClient, $this->clientId);
	}
}
