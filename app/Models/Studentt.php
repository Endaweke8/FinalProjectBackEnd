<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studentt extends Model
{
    use HasFactory;
    protected $table='students';

    protected $fillable=[
        'name',
        'class',
        'section',
        'email',
        'status'

    ];
}
