<?php

namespace TenantCloud\TazWorksSDK\Clients;

use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantsApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;

interface ClientApi
{
	public function applicants(): ApplicantsApi;

	public function orders(): OrdersApi;
}
