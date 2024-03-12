<?php

namespace Astrogoat\Cypress\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StartedTestingSpecFile implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function broadcastAs(): string
    {
        return 'tests.spec-started';
    }

    public function broadcastOn(): Channel
    {
        return new Channel('astrogoat.cypress');
    }
}
