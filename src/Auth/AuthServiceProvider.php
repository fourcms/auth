<?php

namespace FourCms\Auth;

use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use FourCms\Auth\Repositories\RemoteUserRepository;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(AuthManager $auth)
    {
        $auth->provider('itdc', function ($app, array $config) {
            $repository = $app->make(RemoteUserRepository::class);

            return new RemoteUserProvider($app['hash'], $app['cache'], $repository, $config);
        });

    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \Longman\Platfourm\Contracts\Auth\AuthUserService::class,
            \Longman\Platfourm\Auth\Services\AuthUserService::class
        );

    }
}
