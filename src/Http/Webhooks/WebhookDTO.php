<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\UseDefaultForUnexpected;
use Illuminate\Support\Str;

/**
 * {
 * "version": 1,
 * "resourceGuid": "3ebb89c2-391c-406b-a529-fc2841e2cfa2",
 * "event": "order.search.completed",
 * "resourcePath": "/clients/a68f2ea1-d7ce-46ff-8919-c3839b007a43/orders/5da87ec6-bb3b-4ab1-b0c7-b1112822a80c/searches/3ebb89c2-391c-406b-a529-fc2841e2cfa2",
 * "timestamp": 1580153480,
 * "baseClientGuid": "a68f2ea1-d7ce-46ff-8919-c3839b007a43",
 * "instanceGuid": "ed583a4c-50a9-419f-9c89-f4c7e04a5cb6"
 * }
 */
class WebhookDTO
{
	public function __construct(
		public readonly int $version,
		#[SerializedName('resourceGuid')]
		public readonly string $resourceId,
		public readonly string $resourcePath,
		#[SerializedName('baseClientGuid')]
		public readonly string $baseClientId,
		#[SerializedName('instanceGuid')]
		public readonly string $instanceId,
		#[UseDefaultForUnexpected]
		public readonly ?WebhookEventType $event = null,
	) {}

	public function idFromResourcePath(string $after, string $before): string
	{
		return Str::of($this->resourcePath)
			->after($after)
			->before($before)
			->toString();
	}
}
