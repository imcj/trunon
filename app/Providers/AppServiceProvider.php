<?php

namespace App\Providers;

use App\Core\Deploy;
use App\Core\Impl\DeployFactoryImpl;
use App\Core\Translater;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

use App\User;
use App\Model\Observer\UserObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);

        Validator::extend(
            'processIdentifier',
            'App\Validator\ProcessValidator@processIdentifier'
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $deployFactory = new DeployFactoryImpl();
        $this->app->instance(Deploy::class, $deployFactory->create());

        $this->app->bind(Program::class, Program::class);
        $this->app->bind(Translater::class, Translater::class);
    }
}
