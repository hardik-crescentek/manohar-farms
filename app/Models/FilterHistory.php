<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilterHistory extends Model
{
    use HasFactory;

    protected $table = 'filter_history';

    protected $fillable = [
        'name',
        'company',
        'location',
        'last_cleaning_date',
        'bore_wells_id',
        'filter_notification'
    ];

    protected $dates = ['cleaning_date', 'created_at', 'updated_at','deleted_at'];

    protected $casts = [
        'cleaning_date' => 'datetime:d-m-Y',
    ];
}
