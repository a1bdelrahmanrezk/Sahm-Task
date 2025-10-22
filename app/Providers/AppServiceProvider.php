<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use App\Modules\Tasks\Events\TaskCompletedEvent;
use App\Modules\Tasks\Listeners\SendTaskCompletedWebhookListener;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            TaskCompletedEvent::class,
            [SendTaskCompletedWebhookListener::class, 'handle']
        );
    }
}
