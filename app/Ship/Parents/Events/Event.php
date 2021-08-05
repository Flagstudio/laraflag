<?php

namespace App\Ship\Parents\Events;

use App\Ship\Apiato\Abstracts\Events\Event as AbstractEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

abstract class Event extends AbstractEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
}
