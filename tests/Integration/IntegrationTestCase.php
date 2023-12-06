<?php

namespace Tests\Integration;

use Orchestra\Testbench\TestCase;
use TenantCloud\TazWorksSDK\TazWorksSDKServiceProvider;

class IntegrationTestCase extends TestCase
{
	protected function getPackageProviders($app): array
	{
		return [
			TazWorksSDKServiceProvider::class,
		];
	}
}
