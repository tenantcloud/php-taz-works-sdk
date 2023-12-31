<?php

namespace TenantCloud\TazWorksSDK\Fake;

use GoodPhp\Serialization\Serializer;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\CacheInterface;
use TenantCloud\TazWorksSDK\Clients\ClientApi;
use TenantCloud\TazWorksSDK\Fake\Clients\FakeClientApi;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;
use TenantCloud\TazWorksSDK\TazWorksClient;

/**
 * @phpstan-type FakeClients array<string, array{ products: array<string, array{ searches: array<int, array{ type: SearchResultType, display_name: string, set: string }> }> }>
 */
class FakeTazWorksClient implements TazWorksClient
{
	/**
	 * @param FakeClients $clients
	 */
	public function __construct(
		public readonly CacheInterface $cache,
		public readonly Serializer $serializer,
		public readonly array $clients,
		public readonly ?EventDispatcherInterface $events = null,
	) {}

	public function client(string $id): ClientApi
	{
		return new FakeClientApi($this, $id);
	}
}
