<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AskStock extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'firstName',
        'lastName',
        'phone',
        'email',
        'amount',
        'buying_price',
        'user_id',
         'address',
         'description',
         'stockType',
        'created_at',
        'updated_at'
        
    ];
}
