<?php

namespace Timegridio\Backend;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TimegridioBackendServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // use this if your package has views
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'Backend');

        // $this->publishes([
        //     realpath(__DIR__.'/resources/views') => resource_path('views/vendor/backend'),
        // ]);

        // Publish Tests
        $this->publishes([
            realpath(__DIR__.'/../tests') => base_path('tests/integration/backend')
        ], 'tests');

        $this->setupRoutes($this->app->router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $routeGroup = [
            'as'         => 'root.',
            'prefix'     => 'root',
            'middleware' => ['web', 'role:root'],
            'namespace'  => 'Timegridio\Backend\Http\Controllers',
            ];

        $router->group($routeGroup, function ($router) {
            require __DIR__.'/Http/routes.php';
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackend();

        // use this if your package has a config file
        // config([
        //         'config/Backend.php',
        // ]);
    }

    private function registerBackend()
    {
        $this->app->bind('Backend', function ($app) {
            return new Backend($app);
        });
    }
}
