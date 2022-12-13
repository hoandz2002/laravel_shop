<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'code_ship',
        'status',
    ];
    // 
    public function scopeSearch($query)
    {
        if ($key = request()->search) {
            $query = $query->where('order_id', 'like', '%' . $key . '%');
        }
        // dd($query);
        return $query;
    }
}
