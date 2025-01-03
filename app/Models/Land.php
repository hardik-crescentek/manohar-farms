<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'plant_id',
        'image',
        'name',
        'slug',
        'address',
        'plants',
        'wells',
        'pipeline'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function waterEntries()
    {
        return $this->hasMany(WaterEntry::class, 'land_id');
    }

    public function fertilizerEntries()
{
    return $this->hasMany(FertilizerEntry::class, 'land_id');
}
}
