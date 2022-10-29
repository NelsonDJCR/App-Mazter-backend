<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCartItem extends Model
{
    use HasFactory;

    public function scopeGetProduct($query)
    {
        return $query->leftjoin("products", "products.id", "shopping_cart_items.product_id");
    }
}
