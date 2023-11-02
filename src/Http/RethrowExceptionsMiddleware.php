<?php

namespace TenantCloud\TazWorksSDK\Http;

use GuzzleHttp\Exception\RequestException;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\TazWorksSDK\UnderMaintenanceException;
use Throwable;

class RethrowExceptionsMiddleware
{
	public static function make(): callable
	{
		return GuzzleMiddleware::rethrowException(static function (Throwable $e) {
			if (!$e instanceof RequestException) {
				throw $e;
			}

			if ($e->getResponse()?->getStatusCode() === 503) {
				throw new UnderMaintenanceException();
			}

			throw $e;
		});
	}
}
