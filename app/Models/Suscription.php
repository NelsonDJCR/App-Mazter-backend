<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suscription extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'suscription_id';
    protected $fillable = [
        'months_duration',
        'suscription_price',
        'business_type_id',
    ];
}
