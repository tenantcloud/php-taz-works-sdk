<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

use Crell\Serde\SerdeCommon;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;

final class WebhookController
{
	public function __construct(
		private readonly SerdeCommon $serializer,
		private readonly LoggerInterface $logger,
		private readonly Dispatcher $events,
	)
	{
	}

	/**
	 * Example URL: POST /webhooks/taz_works
	 */
	public function store(Request $request): Response
	{
		// Event type is not supported by the SDK, ignore
		if (!WebhookEventType::tryFrom($request->input('event'))) {
			return new Response(status: Response::HTTP_NO_CONTENT);
		}

		$body = $this->serializer->deserialize($request->all(), from: 'array', to: WebhookDTO::class);

		$event = match ($body->event) {
			WebhookEventType::ORDER_COMPLETED => new OrderCompletedEvent($body->resourceId),
			default => null,
		};

		// Event type is not supported by the SDK, ignore
		if (!$event) {
			return new Response(status: Response::HTTP_NO_CONTENT);
		}

		$this->events->dispatch($event);

		return new Response(status: Response::HTTP_NO_CONTENT);
	}
}
