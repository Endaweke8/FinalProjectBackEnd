<?php

namespace App\Models;

use App\Models\Product;
use App\Models\ProductFeature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductFeature extends Model
{
    use HasFactory;


     protected $fillable = [
        'title',
        'value',
        'product_id'
        
        
    ];


    public function product(){
        return $this->belongsTo(Product::class);
    }


}
