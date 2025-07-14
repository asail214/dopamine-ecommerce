<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        // add your cart columns here
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
