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
        'code_booking',
        'total_price',
    ];
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class)->latest();
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
    