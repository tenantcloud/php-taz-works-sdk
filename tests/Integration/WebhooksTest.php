<?php

namespace Tests\Integration;

use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\DataProvider;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchCompletedEvent;

class WebhooksTest extends IntegrationTestCase
{
	private const API_PATH = '/webhooks/taz_works';
	private const AUTHORIZATION = 'test';

	protected function setUp(): void
	{
		parent::setUp();

		Event::fake([
			OrderCompletedEvent::class,
			OrderSearchCompletedEvent::class,
		]);

		config()->set('app.debug', true);
		config()->set('taz_works.webhooks.authorization', self::AUTHORIZATION);
	}

	#[DataProvider('emitsEventProvider')]
	public function testEmitsEvent(array $data, callable $assertDispatched): void
	{
		$this
			->postJson(self::API_PATH, data: $data, headers: [
				'Authorization' => self::AUTHORIZATION,
			])
			->assertNoContent();

		$assertDispatched();
	}

	public static function emitsEventProvider(): iterable
	{
		yield 'order completed' => [
			[
				'version'            => 1,
				'resourceGuid'       => '1f0b8cf0-708c-43b1-9e07-ad382fe3dc7d',
				'event'              => 'order.completed',
				'resourcePath'       => '/clients/c6f82905-88fd-40d7-842d-ec64cbc14a65/orders/1f0b8cf0-708c-43b1-9e07-ad382fe3dc7d',
				'timestamp'          => 1701868358884,
				'instanceGuid'       => '058a7fd7-0e6c-4b47-94d3-44b33b0ae9e1',
				'baseClientGuid'     => 'c6f82905-88fd-40d7-842d-ec64cbc14a65',
				'externalIdentifier' => '1',
			],
			function () {
				Event::assertDispatchedTimes(OrderCompletedEvent::class);
				Event::assertDispatched(
					fn (OrderCompletedEvent $event) => $event->id === '1f0b8cf0-708c-43b1-9e07-ad382fe3dc7d'
				);
			},
		];

		yield 'order search completed' => [
			[
				'version'            => 1,
				'resourceGuid'       => 'dea75cb6-030e-4aea-9e9e-d3ed1b655704',
				'event'              => 'order.search.completed',
				'resourcePath'       => '/clients/c6f82905-88fd-40d7-842d-ec64cbc14a65/orders/1f0b8cf0-708c-43b1-9e07-ad382fe3dc7d/searches/dea75cb6-030e-4aea-9e9e-d3ed1b655704',
				'timestamp'          => 1701868357826,
				'instanceGuid'       => '058a7fd7-0e6c-4b47-94d3-44b33b0ae9e1',
				'baseClientGuid'     => 'c6f82905-88fd-40d7-842d-ec64cbc14a65',
				'externalIdentifier' => null,
			],
			function () {
				Event::assertDispatchedTimes(OrderSearchCompletedEvent::class);
				Event::assertDispatched(
					fn (OrderSearchCompletedEvent $event) => $event->orderId === '1f0b8cf0-708c-43b1-9e07-ad382fe3dc7d' &&
						$event->id === 'dea75cb6-030e-4aea-9e9e-d3ed1b655704'
				);
			},
		];
	}

	public function testWithInvalidToken(): void
	{
		$this
			->postJson(self::API_PATH, headers: [
				'Authorization' => 'test2',
			])
			->assertForbidden();

		Event::assertNothingDispatched();
	}
}
