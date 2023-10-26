<?php

namespace TenantCloud\TazWorksSDK\Http;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use TenantCloud\GuzzleHelper\GuzzleMiddleware;
use TenantCloud\TazWorksSDK\UnderMaintenanceException;
use Throwable;

use function TenantCloud\GuzzleHelper\psr_response_to_json;

class RethrowExceptionsMiddleware
{
	public static function make(): callable
	{
		return GuzzleMiddleware::rethrowException(static function (Throwable $e) {
			if (!$e instanceof RequestException || !$e->hasResponse()) {
				throw $e;
			}

			if ($e->getResponse()->getStatusCode() === 503) {
				throw new UnderMaintenanceException();
			}

			//			$decodedBody = psr_response_to_json($e->getResponse());
			//
			//			if (!$decodedBody) {
			//				throw $e;
			//			}
			//
			//			$errorName = Arr::get($decodedBody, 'name');
			//			$message = Arr::get($decodedBody, 'message');
			//
			//			if ($errorName === 'UserNotVerified') {
			//				throw new UserNotVerifiedException($message);
			//			}
			//
			//			if ($errorName === 'ReportsNotReady') {
			//				throw new ReportNotReadyException($message);
			//			}
			//
			//			if ($errorName === 'ScreeningRequestsCannotCancel') {
			//				throw new CannotCancelRequestException($message);
			//			}

			throw $e;
		});
	}
}
