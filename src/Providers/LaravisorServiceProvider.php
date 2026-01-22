<?php

namespace Sam\Laravisor\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Sam\Laravisor\Http\Middleware\VerifyLaravisorViewer;

class LaravisorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/laravisor.php',
            'laravisor'
        );
    }

    public function boot(Router $router)
    {
        // Publish config ONLY
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/laravisor.php' => config_path('laravisor.php'),
            ], 'laravisor-config');
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'laravisor');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/laravisor.php');

        // Register middleware
        $router->aliasMiddleware(
            'laravisor.viewer',
            VerifyLaravisorViewer::class
        );

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/laravisor'),
        ], 'laravisor-views');
    }
}
