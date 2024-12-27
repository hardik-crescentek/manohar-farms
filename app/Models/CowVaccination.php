<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CowVaccination extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cow_id',
        'disease_name',
        'medicine_name',
        'date',
        'doctor',
        'hospital',
    ];

    protected $dates = ['date', 'deleted_at'];
}