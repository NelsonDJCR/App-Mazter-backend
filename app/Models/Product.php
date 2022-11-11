<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'barcode',
        'purshase_price',
        'size',
        'sales',
        'store_id',
        'product_state',
        'route_image',
    ];

    static function getProducts()
    {
        return self::where('state', 1)->get();
    }
}
