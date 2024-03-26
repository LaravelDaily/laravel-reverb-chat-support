<?php

namespace App\Http\Controllers;

use App\Events\UserSendChatMessageEvent;
use App\Models\ChatRoom;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function __invoke(Request $request)
    {
        $message = $request->input('message');
        $identifier = $request->input('identifier');

        $chatRoom = ChatRoom::query()
            ->where('user_id', auth()->id())
            ->where('identifier', $identifier)
            ->first();

        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'user_id' => auth()->id(),
                'identifier' => $identifier
            ]);
        }

        $message = $chatRoom->chatMessages()->create([
            'user_id' => auth()->id(),
            'message' => $message
        ]);

        event(new UserSendChatMessageEvent($message));

        return response()->json([], 201);
    }
}
