<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_product extends Model
{
    use HasFactory;
    protected $fillable = [
        'size_Id',
        'material_Id',
        'product_Id',
        'price',
        'sale_value',
        'type_sale',
        'quantity'
    ];

    // public function product() {
    //     return $this->belongsTo('App\Models\Product');
    // }

    // public function size() {
    //     return $this->belongsTo('App\Models\Size');
    // }
    
}
