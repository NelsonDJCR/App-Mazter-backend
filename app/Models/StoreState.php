<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreState extends Model
{
    use HasFactory,SoftDeletes;
    protected $primaryKey = 'store_state_id';
    protected $fillable = [
        'store_state_name',
        'date_end_at',
    ];
}
