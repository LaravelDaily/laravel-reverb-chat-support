<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;

class CustomerChatsController extends Controller
{
    public function index()
    {
        $chatRooms = ChatRoom::query()
            ->with(['user'])
            ->withCount('chatMessages')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);

        return view('chatRooms.index', compact('chatRooms'));
    }

    public function show(ChatRoom $chatRoom)
    {
        $chatRoom->load(['chatMessages', 'chatMessages.user']);

        return view('chatRooms.show', compact('chatRoom'));
    }
}
