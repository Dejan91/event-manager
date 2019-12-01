<?php

namespace App\Providers;

use App\User;
use App\Event;
use App\Events;
use Elasticsearch\Client;
use App\Observers\UserObserver;
use Elasticsearch\ClientBuilder;
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
        $this->app->bind(Events\EventsRepository::class, function () {
            $request = app(\Illuminate\Http\Request::class);

            if(config('services.search.engine') === 'Eloquent') {
                return new Events\EloquentRepository($request);
            }

            return new Events\ElasticsearchRepository(
                $this->app->make(Client::class),
                $request
            );
        });

        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
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
    }
}
