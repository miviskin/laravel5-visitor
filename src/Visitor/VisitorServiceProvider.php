<?php

namespace Miviskin\Visitor;

use Illuminate\Support\ServiceProvider;

class VisitorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/visitor.php' => config_path('visitor.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('visitor.browser', function($app) {
            return new Browser(
                $app['request']->server->get('HTTP_USER_AGENT'),
                $app['config']->get('visitor.browser')
            );
        });

        $this->app->singleton('visitor.referer', function ($app) {
            return new URL($app['request']->server->get('HTTP_REFERER'));
        });

        $this->app->singleton('visitor.request_url', function ($app) {
            /** @var \Symfony\Component\HttpFoundation\Request $request */
            $request = $app['request'];

            if (null !== $queryString = $request->getQueryString()) {
                $queryString = '?' . $queryString;
            }

            return new URL(
                $request->getSchemeAndHttpHost() . '/' . trim($request->getRequestUri(), '/') . $queryString
            );
        });

        $this->app->singleton('visitor.ip', function ($app) {
            return new IP($app['request']->server->get('REMOTE_ADDR'));
        });

        $this->app->singleton('visitor', function ($app) {
            return new Visitor(
                $app['request'],
                $app['visitor.browser'],
                $app['visitor.referer'],
                $app['visitor.request_url'],
                $app['visitor.ip']
            );
        });

        $this->mergeConfigFrom(__DIR__ . '/config/visitor.php', 'visitor');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'visitor.browser',
            'visitor.referer',
            'visitor.request_url',
            'visitor.ip',
            'visitor',
        ];
    }
}
