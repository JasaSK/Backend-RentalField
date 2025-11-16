<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = [
        'field_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];
}
