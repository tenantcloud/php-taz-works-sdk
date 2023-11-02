<?php

namespace TenantCloud\TazWorksSDK;

use GoodPhp\Serialization\Serializer;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use TenantCloud\TazWorksSDK\EventImitation\EventImitatingEventDispatcher;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Http\Webhooks\AuthorizeMiddleware;
use TenantCloud\TazWorksSDK\Http\Webhooks\WebhookController;

/**
 * @phpstan-import-type FakeClients from FakeTazWorksClient
 */
class TazWorksSDKServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->publishes([
			__DIR__ . '/../resources/config/taz_works.php' => $this->app->configPath('taz_works.php'),
		]);

		$this->webhooksRoute();
	}

	public function register(): void
	{
		parent::register();

		$this->mergeConfigFrom(
			__DIR__ . '/../resources/config/taz_works.php',
			'taz_works'
		);

		$this->registerWebhookBindings();

		$this->app->singleton('taz_works.serializer', fn () => SerializerFactory::make());

		if (!$this->app->make(ConfigRepository::class)->get('taz_works.fake.enabled')) {
			$this->registerHttpClient();
		} else {
			$this->registerFakeClient();
		}
	}

	private function webhooksRoute(): void
	{
		$config = $this->app->make(ConfigRepository::class);
		$router = $this->app->make(Router::class);

		/** @var string $prefix */
		$prefix = $config->get('taz_works.webhooks.prefix');

		$router->middleware(AuthorizeMiddleware::class)
			->prefix($prefix)
			->post('/', WebhookController::class)
			->name('taz_works.webhooks');
	}

	private function registerWebhookBindings(): void
	{
		$this->app->bind(AuthorizeMiddleware::class, function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			/** @var string $authorization */
			$authorization = $config->get('taz_works.webhooks.authorization');

			return new AuthorizeMiddleware($authorization);
		});

		$this->app
			->when(WebhookController::class)
			->needs(Serializer::class)
			->give('taz_works.serializer');
	}

	private function registerHttpClient(): void
	{
		$this->app->singleton(TazWorksClient::class, static function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			/** @var string $baseUrl */
			$baseUrl = $config->get('taz_works.base_url');
			/** @var string $apiToken */
			$apiToken = $config->get('taz_works.api_token');

			return new HttpTazWorksClient(
				$baseUrl,
				$apiToken,
				$container->make('taz_works.serializer'),
				$config->get('taz_works.webhooks.imitate') ? $container->make(EventImitatingEventDispatcher::class) : null,
				$container->make(LoggerInterface::class),
			);
		});
	}

	private function registerFakeClient(): void
	{
		$this->app->singleton(TazWorksClient::class, static function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			/** @var FakeClients $clients */
			$clients = $config->get('taz_works.fake.clients');

			return new FakeTazWorksClient(
				$container->make(CacheRepository::class),
				$container->make('taz_works.serializer'),
				$clients,
				$container->make(EventImitatingEventDispatcher::class),
			);
		});
	}
}
