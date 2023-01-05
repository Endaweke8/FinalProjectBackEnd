<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookmark extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'quantity',
        'user_id',
        'created_at',
        'updated_at'
        
    ];

    public function product(){
        return $this->hasMany(Product::class,'id','product_id');
    }
}
