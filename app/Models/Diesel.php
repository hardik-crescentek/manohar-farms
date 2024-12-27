<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diesel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diesel_managements';

    protected $fillable = ['volume', 'price', 'total_price', 'date', 'payment_person'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'price' => 'integer',
        'total_price' => 'integer',
        'volume' => 'integer',
    ];
}
