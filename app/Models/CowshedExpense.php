<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CowshedExpense extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'image',
        'amount',
        'payment_person',
        'date',
    ];

    protected $dates = ['date', 'deleted_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
