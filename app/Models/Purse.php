<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purse extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'surplus',
        'status',
    ];
}
