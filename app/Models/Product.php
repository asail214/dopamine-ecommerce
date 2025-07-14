<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    // These fields will be translated (stored in product_translations table)
    public $translatedAttributes = ['name', 'description', 'short_description'];
    
    // These fields are stored in the main products table
    protected $fillable = [
        'sku', 
        'slug', 
        'price', 
        'stock_quantity', 
        'active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
    ];

    /**
     * Relationship with categories (if you have categories)
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Relationship with order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Relationship with cart items
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Relationship with reviews
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope for products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Get the product's discounted price (if you have discounts)
     */
    public function getDiscountedPriceAttribute()
    {
        // Add discount logic here if needed
        return $this->price;
    }
}