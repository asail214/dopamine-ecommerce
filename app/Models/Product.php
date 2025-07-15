<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Sluggable;

    // These fields will be translated (stored in product_translations table)
    public $translatedAttributes = ['name', 'description', 'short_description', 'meta_title', 'meta_description', 'meta_keywords'];
    
    // These fields are stored in the main products table
    protected $fillable = [
        'sku', 
        'slug', 
        'price', 
        'compare_price', // ADDED: For original price when on sale
        'cost_price', // ADDED: For profit calculations
        'stock_quantity', 
        'min_stock_level', // ADDED: For low stock alerts
        'weight', // ADDED: For shipping calculations
        'dimensions', // ADDED: For shipping
        'status', // CHANGED: from 'active' to 'status' for better enum support
        'featured', // ADDED: For featured products
        'digital', // ADDED: For digital products
        'requires_shipping', // ADDED
        'taxable', // ADDED
        'track_quantity', // ADDED
        'created_by', // ADDED: Admin who created
        'published_at' // ADDED: For scheduled publishing
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

    // Status constants as per SRS
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
     * Scopes as per SRS requirements
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
                    ->where('published_at', '<=', now());
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
     * Attribute methods for SRS requirements
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
        return $this->stock_quantity <= $this->min_stock_level;
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
     * Business methods for SRS requirements
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