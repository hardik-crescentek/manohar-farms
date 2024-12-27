<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaterEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'land_id',
        'land_part_id',
        'date',
        'time',
        'person',
        'volume',
        'notes',
        'hours'
    ];

    protected $dates = ['deleted_at'];

    public function land() {
        return $this->belongsTo(Land::class);
    }

    public function landPart() {
        return $this->belongsTo(LandPart::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'land_part_id' => 'array',
        'volume' => 'integer'
    ];
}
