<?php

namespace App\Models;

use App\Models\Image;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'updated_at',
        'category_id',
        'videopath'
        
    ];


    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function stars(){
        return $this->hasMany('App\Models\Rating');
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class)->orderBy('created_at','desc');;
    }


    public function product_feature(){
        return $this->hasMany(ProductFeature::class)->orderBy('created_at','desc');;
    }

}
