<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = [
        'field_id',
        'date',
        'start_time',
        'end_time',
        'reason',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
