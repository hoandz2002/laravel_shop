<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'nameProduct',
        'size',
        'description',
        'avatar',
        'category_id',
        'size_id',
        'statusPrd',
        'mass',
        'sale',
        'SKU',
    ];
    public function scopeSearch($query) {
        if($key = request()->search){
            $query = $query->where('nameProduct','like', '%'.$key.'%');
        }
        // dd($query);
        return $query;
    }
}
