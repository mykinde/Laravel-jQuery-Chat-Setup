<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat');
    }

    public function fetchMessages()
    {
        return Message::with('user')->latest()->take(50)->get()->reverse()->values();
    }

    public function sendMessage(Request $request)
    {
        $message = Auth::user()->messages()->create([
            'body' => $request->body,
        ]);

        return $message->load('user');
    }
}
