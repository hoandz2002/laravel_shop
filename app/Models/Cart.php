<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";
    protected $fillable = [
        'userId',
        'productId',
        'quantity',
        'price',
        'size_id',
        'material_id',
        'color_id',
        'price_product_id'
    ];

    //  public function product_prices()
    // {
    //     return $this->hasMany(Price_product::class, 'id', 'product_Id');
    // }
}
