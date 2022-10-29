<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    public function getListProducts()
    {
        return $this->hasMany(ShoppingCartItem::class)->getProduct();
    }

}
