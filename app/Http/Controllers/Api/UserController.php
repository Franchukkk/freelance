<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use Illuminate\Http\Request;
use App\Models\Message;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function messages(Request $request, $user_id)
    {
        $messages = Message::where('receiver_id', $user_id)->orWhere('sender_id', $user_id)->get();

        return MessageResource::collection($messages);
    }

}
