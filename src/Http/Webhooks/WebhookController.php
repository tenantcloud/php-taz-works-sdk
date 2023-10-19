<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

use GoodPhp\Serialization\Serializer;
use GoodPhp\Serialization\TypeAdapter\Primitive\PrimitiveTypeAdapter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchCompletedEvent;

final class WebhookController
{
	public function __construct(
		private readonly Serializer $serializer,
		private readonly Dispatcher $events,
	)
	{
	}

	/**
	 * Example URL: POST /webhooks/taz_works
	 */
	public function __invoke(Request $request): Response
	{
		// Event type is not supported by the SDK, ignore
		if (!WebhookEventType::tryFrom($request->input('event'))) {
			return new Response(status: Response::HTTP_NO_CONTENT);
		}

		$body = $this->serializer
			->adapter(PrimitiveTypeAdapter::class, WebhookDTO::class)
			->deserialize($request->all());

		$event = match ($body->event) {
			WebhookEventType::ORDER_COMPLETED => new OrderCompletedEvent($body->resourceId),
			WebhookEventType::ORDER_SEARCH_COMPLETED => new OrderSearchCompletedEvent($body->resourceId, $body->idFromResourcePath('/orders/', '/searches')),
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
