<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'store_id';
    protected $fillable = [
        'business_name',
        'propetiary_name',
        'address',
        'store_phone',
        'store_phone_secondary',
        'picture_business',
        'city',
        'business_type_id',
        'logo',
        'color_primary',
        'color_secondary',
    ];
}
