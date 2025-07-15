<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Temporarily disable translations
// use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
// use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model // Remove TranslatableContract for now
{
    use HasFactory, Sluggable; // Remove Translatable for now

    // Temporarily disable translations
    // public $translatedAttributes = ['name', 'description', 'short_description', 'meta_title', 'meta_description', 'meta_keywords'];
    
    // Store all fields directly in the main products table
    protected $fillable = [
        'name',           // Move to main table
        'description',    // Move to main table
        'short_description',
        'sku', 
        'slug', 
        'price', 
        'compare_price',
        'cost_price',
        'stock_quantity', 
        'min_stock_level',
        'weight',
        'dimensions',
        'status',
        'featured',
        'digital',
        'requires_shipping',
        'taxable',
        'track_quantity',
        'created_by',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'dimensions' => 'array',
        'featured' => 'boolean',
        'digital' => 'boolean',
        'requires_shipping' => 'boolean',
        'taxable' => 'boolean',
        'track_quantity' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Status constants
    const STATUS_DRAFT = 'draft';
    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_OUT_OF_STOCK = 'out_of_stock';

    public static function getStatuses()
    {
        return [
            self::STATUS_DRAFT => 'Draft',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
        ];
    }

    // Sluggable configuration
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true,
            ]
        ];
    }

    /**
     * Relationships
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                    ->where(function($q) {
                        $q->where('published_at', '<=', now())
                          ->orWhereNull('published_at');
                    });
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0)
                    ->orWhere('track_quantity', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('stock_quantity', '<=', 'min_stock_level')
                    ->where('track_quantity', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }

    /**
     * Attribute methods
     */
    public function getIsInStockAttribute()
    {
        if (!$this->track_quantity) {
            return true;
        }
        return $this->stock_quantity > 0;
    }

    public function getIsLowStockAttribute()
    {
        if (!$this->track_quantity) {
            return false;
        }
        return $this->stock_quantity <= ($this->min_stock_level ?? 0);
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->compare_price || $this->compare_price <= $this->price) {
            return 0;
        }
        return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
    }

    public function getIsOnSaleAttribute()
    {
        return $this->compare_price && $this->compare_price > $this->price;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Business methods
     */
    public function decrementStock($quantity)
    {
        if ($this->track_quantity) {
            $this->decrement('stock_quantity', $quantity);
        }
    }

    public function incrementStock($quantity)
    {
        if ($this->track_quantity) {
            $this->increment('stock_quantity', $quantity);
        }
    }

    public function canPurchase($quantity = 1)
    {
        if (!$this->track_quantity) {
            return true;
        }
        return $this->stock_quantity >= $quantity;
    }

    public function generateSku()
    {
        $prefix = 'PRD';
        $timestamp = time();
        $random = strtoupper(substr(md5(uniqid()), 0, 4));
        return $prefix . $timestamp . $random;
    }
}