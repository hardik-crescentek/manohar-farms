<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandPart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['land_id', 'name', 'plants', 'image', 'color'];

    public function land() {
        return $this->belongsTo(Land::class);
    }
}
