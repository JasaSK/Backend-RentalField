<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryField extends Model
{
    protected $table = 'category_fields';

    protected $fillable = [
        'name',
    ];

    public function fields()
    {
        return $this->hasMany(Field::class);
    }
}
