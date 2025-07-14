<?php

namespace App\Models;

#use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model implements TranslatableContract
{
    use HasRecursiveRelationships, Translatable;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['slug', 'parent_id', 'sort_order', 'is_active'];

    public function getParentKeyName()
    {
        return 'parent_id';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}