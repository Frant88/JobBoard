<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
use HasFactory;
    protected $fillable = [
    'github_url', 
    'cv_path', 
    'company_name', 
    'vat_number', 
    'user_id' // Importante: includi user_id se usi create()
];
      public function user()
{
    // Questo dice che il profilo "appartiene" a un utente
    return $this->belongsTo(User::class);
}
}
