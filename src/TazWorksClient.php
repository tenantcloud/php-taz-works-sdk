<?php

namespace TenantCloud\TazWorksSDK;

use TenantCloud\TazWorksSDK\Clients\ClientApi;

interface TazWorksClient
{
	public function client(string $id): ClientApi;
}
