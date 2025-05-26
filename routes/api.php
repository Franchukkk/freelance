<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MessageController;

Route::prefix('v1')->group(function () {
    Route::get('user/messages/{user_id}', [UserController::class, 'messages'])->name('user.messages');
    Route::get('message/{id}', [MessageController::class, 'show'])->name('message.show');
});