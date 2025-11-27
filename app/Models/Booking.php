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


/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Get the field that owns the Booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
/*******  3b8bbb9b-a7e6-41b9-8ac0-4b53e598be36  *******/    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
