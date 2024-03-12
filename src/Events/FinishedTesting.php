<?php

namespace Astrogoat\Cypress\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class FinishedTesting implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastAs() : string
    {
        return 'tests.finished';
    }

    public function broadcastOn() : Channel
    {
        return new Channel('astrogoat.cypress');
    }
}
