<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'ticket';
    protected $fillable = [
        'ticket_code',
        'booking_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
