<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'orderDate',
        'user_id',
        'oderStatus',
        'phone',
        'address',
        'oderEmail',
        'orderName',
        'orderShip',
        'total',
    ];
}
