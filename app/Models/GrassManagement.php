<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrassManagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'image',
        'volume',
        'amount',
        'date',
        'payment_person',
    ];

    protected $dates = ['date', 'deleted_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
