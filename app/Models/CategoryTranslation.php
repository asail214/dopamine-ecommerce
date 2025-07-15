<?php

// 1. CategoryTranslation Model (MISSING)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name', 
        'description',
        'meta_title',
        'meta_description'
    ];
}