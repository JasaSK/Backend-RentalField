<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';
    protected $fillable = [
        'name',
        'description',
        'image',
        'category_gallery_id',
    ];

    public function categoryGallery()
    {
        return $this->belongsTo(CategoryGallery::class, 'category_gallery_id');
    }
}
