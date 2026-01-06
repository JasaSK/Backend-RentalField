<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'no_telp',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_code',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function passwordReset(){
        return $this->hasOne(PasswordReset::class);
    }

    public function emailVerification(){
        return $this->hasOne(EmailVerification::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
