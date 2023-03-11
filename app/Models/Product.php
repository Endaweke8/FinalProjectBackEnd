<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category',
        'subcategory',
        'subcategory1',
        'slug',
        'description',
        'image_name',
        'buying_price',
        'price',
        'sale_price',
        'productquantity',
        'created_at',
        'updated_at'
        
    ];


    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function stars(){
        return $this->hasMany('App\Models\Rating');
    }

}
