<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $table = 'fields';

    protected $fillable = [
        'name',
        'image',
        'description',
        'price_per_hour',
        'duration',
        'open_time',
        'close_time',
        'status',
    ];

    /**
     * Accessor: format harga agar lebih mudah dibaca (opsional)
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price_per_hour, 0, ',', '.');
    }

    /**
     * Scope: ambil hanya lapangan yang tersedia
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
