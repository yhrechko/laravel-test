<?php

namespace App\Providers;

use App\Repositories\IClientRepository;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IClientRepository::class, ClientRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
