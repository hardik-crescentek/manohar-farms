<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CowshedSetting extends Model
{
    use HasFactory;

    protected $table = 'cowshed_settings';

    protected $fillable = [
        'milk_price',
    ];
}
