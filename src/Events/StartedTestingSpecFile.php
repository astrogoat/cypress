<?php

namespace Astrogoat\Cypress\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StartedTestingSpecFile implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function broadcastAs() : string
    {
        return 'tests.spec-started';
    }

    public function broadcastOn() : Channel
    {
        return new Channel('astrogoat.cypress');
    }
}
