<?php

namespace App\Providers;

use App\Jobs\Customer\CustomerCreated;
use App\Jobs\Customer\CustomerDeleted;
use App\Jobs\Customer\CustomerUpdated;
use App\Jobs\NotificationTask\NotificationTaskCreated;
use App\Jobs\NotificationTask\NotificationTaskDeleted;
use App\Jobs\NotificationTask\NotificationTaskUpdated;
use App\Jobs\User\UserCreated;
use App\Jobs\User\UserDeleted;
use App\Jobs\User\UserUpdated;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
        App::bindMethod(UserCreated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(UserUpdated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(UserDeleted::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(CustomerCreated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(CustomerUpdated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(CustomerDeleted::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(NotificationTaskCreated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(NotificationTaskUpdated::class . '@handle', fn($job) => $job->handle());
        App::bindMethod(NotificationTaskDeleted::class . '@handle', fn($job) => $job->handle());
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
