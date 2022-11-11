<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $primaryKey = 'shopping_cart_id';
    protected $fillable = [
        'store_id',
        'shopping_cart_state',
        'cart',
    ];

    public function getListProducts()
    {
        return $this->hasMany(ShoppingCartItem::class,'shopping_cart_id','shopping_cart_id')->getProduct();
    }

}
