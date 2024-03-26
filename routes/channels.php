<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('adminRepliedToChatRoom.{identifier}', function ($user, $identifier) {
    $chatRoom = ChatRoom::where('identifier', $identifier)->first();
    if (!$chatRoom) {
        return true;
    }

    return ChatRoom::where('identifier', $identifier)->where('user_id', $user->id)->exists();
});

Broadcast::channel('userRepliedToChatRoom.{identifier}', function ($user, $identifier) {
    return $user->is_admin;
});