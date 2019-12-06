<?php

namespace App\Providers;

use App\User;
use App\Event;
use App\Observers\UserObserver;
use App\Observers\EventObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Event::observe(EventObserver::class);
    }
}
