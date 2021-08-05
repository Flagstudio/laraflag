<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Apiato\Abstracts\Providers\EventsProvider as AbstractEventsProvider;

class EventsProvider extends AbstractEventsProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];


    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
