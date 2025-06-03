<?php

namespace App\Providers;

use App\Services\MessageBroker\MessageBroker;
use App\Services\MessageBroker\RabbitMQMessageBroker;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            abstract: MessageBroker::class,
            concrete: RabbitMQMessageBroker::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
