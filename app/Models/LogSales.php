<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_id',
        'user_id',
        'json_products',
        'total'
    ];
}
