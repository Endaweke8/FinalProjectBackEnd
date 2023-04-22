<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    public $table="images";

    protected $fillable=[
        'imagepath',
        'product_id'
      ];
  
      public function product(){
          return $this->belongsTo(Product::class);
      }
}
