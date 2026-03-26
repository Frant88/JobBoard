<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebSocketTicket extends Model
{
    use HasFactory;

    protected $table = "websocket_tickets";
    public $timestamps = false;

    protected $fillable= [
        'ticket',
        'user_id',
        'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
