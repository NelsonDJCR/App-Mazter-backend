<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'name',
        'barcode',
        'price',
        'discount',
        'stock',
        'user_id',
    ];

    static function getProducts()
    {
        return self::where('state', 1)->get();
    }
}
