<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientAddress extends Model
{
    use HasFactory;
     protected $fillable=[
        'user_id',
        'city',
        'subcity',
        'kebele',
        'address',
        'phone',
        'email',
        'postal_code',
    ];

      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
