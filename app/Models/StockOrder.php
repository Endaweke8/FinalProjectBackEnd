<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'firstName',
        'lastName',
        'phone',
        'email',
        'amount',
        'buying_price',
        'user_id',
         'address',
        'created_at',
        'updated_at'
        
    ];

    public function stock(){
        return $this->hasMany(Stock::class,'id','stock_id');
    }
}
