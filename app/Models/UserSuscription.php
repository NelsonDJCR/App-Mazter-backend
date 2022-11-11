<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSuscription extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'user_suscription_id';
    protected $fillable = [
        'store_id',
        'suscription_id',
        'payment_method_id',
    ];
}
