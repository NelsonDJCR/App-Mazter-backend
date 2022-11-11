<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suscription extends Model
{
    use HasFactory;
    protected $primaryKey = 'suscription_id';
    protected $fillable = [
        'campaing',
        'month_price',
        'trimester_price',
        'semester_price',
        'yearly_price',
        'month_discount',
        'trimester_discount',
        'semester_discount',
        'yearly_discount',
        'business_type_id',
        'sales',
        'state_suscriptions',
    ];
}
