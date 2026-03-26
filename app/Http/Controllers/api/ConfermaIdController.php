<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\WebSocketTicket;

class ConfermaIdController extends Controller
{
    public function confirmId($ticket){
        $found = WebSocketTicket::where('ticket', $ticket)->where('expires_at','>',now())->first();
        if(!$found){
            return response()->json(['error' =>'Ticket non valido o scaduto'],401);
        }

        $userId = $found->user_id;
        return response()->json(['user_id'=>$userId]);
    }
}
