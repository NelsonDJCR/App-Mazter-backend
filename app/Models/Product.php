<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bar_code',
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
