<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleService extends Model
{
    use SoftDeletes;

    protected $table = 'vehicle_services';

    protected $fillable = [
        'vehicle_id',
        'image',
        'date',
        'price',
        'person',
        'service',
        'note',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'price' => 'integer'
    ];
}
