<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
use HasFactory;
    protected $fillable = [
    'title', 
    'slug', 
    'description', 
    'location',
    'work_type',
    'salary_min', 
    'salary_max',
    'is_active',
    'employer_id',
    'category_id'
];
protected $casts = [
        'is_active' => 'boolean',
    ];
   public function user()
{
    // L'annuncio appartiene a un utente e laravel si aspetta user_id per questo passiamo anche employer_id
    return $this->belongsTo(User::class,'employer_id');
}
public function category()
    {
        return $this->belongsTo(Category::class);
    }

public function skills()
{
    // Laravel cercherà una tabella chiamata 'listing_skill' per impostazione predefinita
    return $this->belongsToMany(Skill::class,'job_skill');
}

public function applications() {
    return $this->hasMany(Application::class);
}
}
