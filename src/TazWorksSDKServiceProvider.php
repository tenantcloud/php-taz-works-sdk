<?php

namespace TenantCloud\TazWorksSDK;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;

class TazWorksSDKServiceProvider extends ServiceProvider
{
	public function boot(): void
	{
		$this->publishes([
			__DIR__ . '/../resources/config/tazworks.php' => $this->app->configPath('tazworks.php'),
		]);

//		if ($this->app->runningInConsole()) {
//			$this->commands([
//				EnableCommand::class,
//				DisableCommand::class,
//				ListCommand::class,
//			]);
//		}
//
//		$config = $this->app->make(ConfigRepository::class);
//		$router = $this->app->make(Router::class);
//
//		$router->middleware(ValidateSignatureMiddleware::class)
//			->prefix($config->get('rentler.webhooks.prefix'))
//			->group(static function () use ($router) {
//				$router->post('listings/matched', ListingsMatchedController::class)
//					->name('rentler.webhooks.listings.matched');
//				$router->post('preferences/matched', PreferencesMatchedController::class)
//					->name('rentler.webhooks.preferences.matched');
//
//				$router->post('leads/created', LeadCreatedController::class)
//					->name('rentler.webhooks.leads.created');
//				$router->post('leads/updated', LeadUpdatedController::class)
//					->name('rentler.webhooks.leads.updated');
//			});
	}

	public function register(): void
	{
		parent::register();

		$this->mergeConfigFrom(
			__DIR__ . '/../resources/config/tazworks.php',
			'tazworks'
		);

		$this->app->singleton(TazWorksClient::class, static function (Container $container) {
			$config = $container->make(ConfigRepository::class);

			return new HttpTazWorksClient(
				$config->get('taz_works.base_url'),
				$config->get('taz_works.api_token'),
				$container->make(LoggerInterface::class),
			);
		});

//		$this->app->bind(ValidateSignatureMiddleware::class, function (Container $container) {
//			$config = $container->make(ConfigRepository::class);
//
//			return new ValidateSignatureMiddleware(
//				$config->get('rentler.webhooks.secret'),
//			);
//		});
//
//		$config = $this->app->make(ConfigRepository::class);
//
//		if (!$config->get('rentler.fake_client')) {
//			$this->app->singleton(RentlerClient::class, static function (Container $container) {
//				$config = $container->make(ConfigRepository::class);
//
//				return new RentlerClientImpl(
//					$config->get('rentler.base_url'),
//					$config->get('rentler.auth_base_url'),
//					$config->get('rentler.client_id'),
//					$config->get('rentler.client_secret'),
//					new CombinedTokenCache([$container->make(LaravelCacheTokenCache::class)]),
//					$container->make(LoggerInterface::class),
//				);
//			});
//		} else {
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
	}
}

