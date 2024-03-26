<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;

class AdminMessageReplyController extends Controller
{
    public function __invoke(Request $request, ChatRoom $chatRoom)
    {
        $message = $request->input('message');

        $chatRoom->chatMessages()->create([
            'user_id' => auth()->id(),
            'message' => $message
        ]);

        return response()->json([], 201);
    }
}
