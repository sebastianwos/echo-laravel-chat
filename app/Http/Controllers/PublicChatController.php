<?php

namespace App\Http\Controllers;

use App\ChatMessage;
use App\Events\ChatMessageWasReceived;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class PublicChatController extends Controller
{

    public function index()
    {
        return ChatMessage::with('user')->get();
    }

    public function store(Request $request)
    {
        $user = Auth::guard('api')->check() ? Auth::guard('api')->user() : null;
        $message = ChatMessage::create([
            'user_id' => $user ? $user->id : null,
            'message' => $request->input('message'),
        ]);
        event(new ChatMessageWasReceived($message, $user));
    }
}
