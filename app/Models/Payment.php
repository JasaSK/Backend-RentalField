<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';
    protected $fillable = ['booking_id', 'payment_order_id', 'qris_url', 'payment_status'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
