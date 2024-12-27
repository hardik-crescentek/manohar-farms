<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoreWells extends Model
{
    use HasFactory;

    protected $table = 'bore_and_wells';

    protected $fillable = ['type','land_id', 'image', 'name', 'depth', 'status'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function land() {
        return $this->belongsTo(Land::class);
    }
}
