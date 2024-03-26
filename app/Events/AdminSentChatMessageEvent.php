<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class AdminSentChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;

    public function __construct(public string $identifier, public string $message)
    {
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('adminRepliedToChatRoom.' . $this->identifier),
        ];
    }
}
