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
        'payment_order_id',
        'ticket_code',
        'qris_url'
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
        return $this->hasMany(Refund::class);
    }
}
