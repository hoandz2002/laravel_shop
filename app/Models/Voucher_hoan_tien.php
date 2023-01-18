<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher_hoan_tien extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'content',
        'refund',
        'end_date',
        'status',
        'quantity',
        'minimum_bill',
    ];
}
