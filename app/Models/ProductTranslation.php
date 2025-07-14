<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 
        'description', 
        'short_description',
        'meta_data'
    ];

    protected $casts = [
        'meta_data' => 'array',
    ];
}