<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combo2 extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_product1',
        'id_product2',
        'product_donate',
        'price_combo2',
    ];
}
