<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infrastructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'land_id', 'land_part_id', 'image', 'amount', 'date', 'payment_person',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
