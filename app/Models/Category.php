<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasRecursiveRelationships;

    // Temporarily disable translations until we create the translation table
    // use Translatable;
    // public $translatedAttributes = ['name', 'description', 'meta_title', 'meta_description'];
    
    protected $fillable = [
        'name',           // Move name to main table temporarily
        'description',    // Move description to main table temporarily
        'slug', 
        'parent_id', 
        'sort_order',
        'is_active',
        'image',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('is_active', true);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function isParent()
    {
        return $this->children()->count() > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public static function getTree()
    {
        return self::active()->whereNull('parent_id')->with('children')->orderBy('sort_order')->get();
    }
}