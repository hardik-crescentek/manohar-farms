<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'amount', 'date', 'image', 'payment_person'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
