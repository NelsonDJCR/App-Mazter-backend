<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'shopping_cart_item_id';
    protected $fillable = [
        'amount',
        'price',
        'product_id',
        'shopping_cart_id',
    ];

    public function scopeGetProduct($query)
    {
        return $query->leftjoin("products", "products.product_id", "shopping_cart_items.product_id");
    }
}
