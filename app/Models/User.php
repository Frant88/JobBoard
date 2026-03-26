<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_employer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_employer'=>'boolean',
        ];
    }
    public function isEmployer(): bool
{
    return $this->is_employer === true;
}

public function isCandidate(): bool
{
    // È l'esatto opposto, ma scritto in modo esplicito
    return $this->is_employer === false;
}

public function profile()
{
    // Laravel cercherà automaticamente una colonna 'user_id' nella tabella 'profiles'
    return $this->hasOne(Profile::class);
}
public function listings()
{
    // L'utente ha molti annunci
    return $this->hasMany(Listing::class, 'employer_id');
}

public function applications() {
    return $this->hasMany(Application::class);
}
public function sendEmailVerificationNotification()
{
    // Questo sposta l'invio in coda invece di farlo subito
    $this->notify((new \App\Notifications\MyVerifyEmail)->delay(now()->addSeconds(5)));
}

public function ticket(){
    return $this->hasMany(WebSocketTicket::class);
}
}
