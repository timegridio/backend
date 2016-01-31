<?php

namespace Alariva\TimegridBackend;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class TimegridBackendServiceProvider extends ServiceProvider
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

        $this->publishes([
            realpath(__DIR__.'/resources/views') => resource_path('views/vendor/backend'),
        ]);

        // use this if your package has routes
        $this->setupRoutes($this->app->router);

        // use this if your package needs a config file
        // $this->publishes([
        //         __DIR__.'/config/config.php' => config_path('TimegridBackend.php'),
        // ]);

        // use the vendor configuration file as fallback
        // $this->mergeConfigFrom(
        //     __DIR__.'/config/config.php', 'TimegridBackend'
        // );
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
            'prefix'     => '_root',
            'middleware' => ['web', 'role:root'],
            'namespace'  => 'Alariva\TimegridBackend\Http\Controllers',
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
        $this->registerTimegridBackend();

        // use this if your package has a config file
        // config([
        //         'config/TimegridBackend.php',
        // ]);
    }

    private function registerTimegridBackend()
    {
        $this->app->bind('TimegridBackend', function ($app) {
            return new Backend($app);
        });
    }
}
