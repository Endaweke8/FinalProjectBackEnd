<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'amount',
        'slug',
        'description',
        'image_name',
        'sale_price',
        'status',
        'created_at',
        'updated_at'
        
    ];
}
