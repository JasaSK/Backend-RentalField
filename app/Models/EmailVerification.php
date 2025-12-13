<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $table = 'email_verifications';

    protected $fillable = [
        'user_id',
        'verification_code',
        'expires_at',
        'last_sent_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'last_sent_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
