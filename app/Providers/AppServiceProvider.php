<?php

namespace App\Providers;

use App\User;
use App\Event;
use App\Observers\UserObserver;
use App\Observers\EventObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\RequestQueryFilter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('filter', function ($app) {
            return new RequestQueryFilter;
        });
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

        Validator::extend('spamfree', 'App\Rules\SpamFree@passes');
    }
}
