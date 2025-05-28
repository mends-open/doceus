<?php

namespace App\Providers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\CreateDefaultEntitiesForVerifiedUser;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Verified::class => [
            CreateDefaultEntitiesForVerifiedUser::class,
        ],
    ];
}
