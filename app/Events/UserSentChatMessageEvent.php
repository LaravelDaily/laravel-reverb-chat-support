<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class UserSentChatMessageEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;

    public function __construct(public ChatMessage $chatMessage)
    {
        $this->chatMessage->load(['chatRoom', 'user']);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('userRepliedToChatRoom.' . $this->chatMessage->chatRoom->id),
        ];
    }
}
