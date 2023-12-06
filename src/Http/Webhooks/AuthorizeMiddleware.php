<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeMiddleware
{
	public function __construct(
		private readonly string $authorization,
	) {}

	public function handle(Request $request, Closure $next): Response
	{
		if ($this->authorization !== $request->header('Authorization')) {
			throw new AuthorizationException();
		}

		return $next($request);
	}
}
