<?php

namespace App\Http\Controllers\chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebSocketTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(){
        $ticketDb=[
            'ticket' => Str::random(16),
            'user_id'=> Auth::id(),
            'expires_at'=>now()->addHour()
        ];
        WebSocketTicket::create($ticketDb);
        $ticket = $ticketDb['ticket'];

        $users = User::where('id','!=',Auth::id())->get();

        return view('chat.chat', compact('ticket','users'));
    }
}
