<?php

use App\Http\Controllers\AdminMessageReplyController;
use App\Http\Controllers\CustomerChatsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SendMessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('chatRooms', CustomerChatsController::class)->only(['index', 'show']);

    Route::post('send-message', SendMessageController::class)->name('send-message');
    Route::post('admin-reply/{chatRoom}', AdminMessageReplyController::class)->name('admin-reply');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
