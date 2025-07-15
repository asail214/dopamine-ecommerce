<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model implements TranslatableContract
{
    use HasRecursiveRelationships, Translatable;

    // FIXED: Added missing translatable attributes
    public $translatedAttributes = ['name', 'description', 'meta_title', 'meta_description'];
    
    protected $fillable = [
        'slug', 
        'parent_id', 
        'sort_order', // FIXED: Was 'order' in migration but 'sort_order' in model
        'is_active',
        'image'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // FIXED: Correct method name for adjacency list
    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }

    // Helper methods for SRS requirements
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

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get category tree for admin dropdown
    public static function getTree()
    {
        return self::active()->whereNull('parent_id')->with('children')->orderBy('sort_order')->get();
    }
}