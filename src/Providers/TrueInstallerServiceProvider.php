<?php

namespace ghulammustafashad\trueinstaller\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use ghulammustafashad\trueinstaller\Middleware\canInstall;
use ghulammustafashad\trueinstaller\Middleware\canUpdate;

class TrueInstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
        $router->middlewareGroup('update', [CanUpdate::class]);
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../Config/trueinstaller.php' => base_path('config/trueinstaller.php'),
        ], 'trueinstaller');

        $this->publishes([
            __DIR__.'/../assets' => public_path('trueinstaller'),
        ], 'trueinstaller');

        $this->publishes([
            __DIR__.'/../Views' => base_path('resources/views/trueinstaller'),
        ], 'trueinstaller');

        $this->publishes([
            __DIR__.'/../Lang' => base_path('resources/lang'),
        ], 'trueinstaller');
    }
}
