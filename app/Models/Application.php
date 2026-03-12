<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
use HasFactory;
    protected $fillable = [
        'cover_letter',
        'status',
        'user_id',
        'listing_id'
    ];

    public function user() {
    return $this->belongsTo(User::class);
}

public function listing() {
    return $this->belongsTo(Listing::class);
}

public function getEmployerNameAttribute(){
    return $this->listing->user->profile?->company_name ?? "Azienda non trovatra";

    //->employer_profile per chiamarlo
}
}
