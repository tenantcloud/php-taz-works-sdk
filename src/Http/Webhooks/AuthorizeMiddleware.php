<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizeMiddleware
{
	public function __construct(
		private readonly string $authorization,
	) {}

	public function handle(Request $request, Closure $next): Response
	{
		if ($request->header('Authorization') !== $this->authorization) {
			throw new AuthorizationException();
		}

		return $next($request);
	}
}
