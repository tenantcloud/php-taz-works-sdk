<?php

namespace TenantCloud\TazWorksSDK;

use Crell\Serde\SerdeCommon;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use TenantCloud\TazWorksSDK\EventImitation\EventImitatingEventDispatcher;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Http\Webhooks\AuthorizeMiddleware;
use TenantCloud\TazWorksSDK\Http\Webhooks\WebhookController;

class TazWorksSDKServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->publishes([
			__DIR__ . '/../resources/config/taz_works.php' => $this->app->configPath('taz_works.php'),
		]);

		$config = $this->app->make(ConfigRepository::class);
		$router = $this->app->make(Router::class);

		$router->middleware(AuthorizeMiddleware::class)
			->prefix($config->get('taz_works.webhooks.prefix'))
			->post('/', WebhookController::class)
			->name('taz_works.webhooks');
	}

	public function register(): void
	{
		parent::register();

		$this->mergeConfigFrom(
			__DIR__ . '/../resources/config/taz_works.php',
			'taz_works'
		);

		$this->app->bind(AuthorizeMiddleware::class, function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			return new AuthorizeMiddleware(
				$config->get('taz_works.webhooks.authorization'),
			);
		});

		$this->app->singleton('taz_works.serializer', fn () => SerializerFactory::make());

		//		$config = $this->app->make(ConfigRepository::class);
//
//		if ($config->get('rentler.fake_client')) {
//			$this->app->singleton(RentlerClient::class, static function (Container $container) {
//				$config = $container->make(ConfigRepository::class);
//
//				return new FakeRentlerClient(
//					$container->make(CacheRepository::class),
//					$config,
//					$container->make(Dispatcher::class),
//					$config->get('rentler.client_id'),
//				);
//			});
//		}
		$this->app->singleton(TazWorksClient::class, static function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			return new HttpTazWorksClient(
				$config->get('taz_works.base_url'),
				$config->get('taz_works.api_token'),
				$container->make('taz_works.serializer'),
				$config->get('taz_works.webhooks.imitate') ? $container->make(EventImitatingEventDispatcher::class) : null,
				$container->make(LoggerInterface::class),
			);
		});

		$this->app
			->when(WebhookController::class)
			->needs(SerdeCommon::class)
			->give('taz_works.serializer');
	}
}

