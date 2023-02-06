<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'barcode',
        'purshase_price',
        'size',
        'product_sales',
        'store_id',
        'product_state',
        'route_image',
    ];

    static function getProducts()
    {
        return self::where('state', 1)->get();
    }
}
