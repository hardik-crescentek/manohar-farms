<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertilizerEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'land_id',
        'land_part_id',
        'fertilizer_name',
        'date',
        'time',
        'person',
        'volume',
        'notes',
        'qty',
        'remarks'
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'land_part_id' => 'array'
    ];

    public function land() {
        return $this->belongsTo(Land::class);
    }

    public function landPart() {
        return $this->belongsTo(LandPart::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
