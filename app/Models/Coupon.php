<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'sale',
        'code',
        'end_date',
        'Minimum_bill',
        'quantity',
        'status',
    ];
}
