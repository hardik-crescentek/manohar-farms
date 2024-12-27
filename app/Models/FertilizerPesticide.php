<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FertilizerPesticide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'quantity',
        'price',
        'date'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'price' => 'integer',
    ];
}
