<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellStock extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'firstName',
        'lastName',
        'phone',
        'email',
        'amount',
        'selling_price',
        'user_id',
         'address',
         'description',
         'stockType',
        'created_at',
        'updated_at'
        
    ];
}
