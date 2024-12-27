<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Water extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'water_managements';

    protected $fillable = ['land_id', 'source', 'volume', 'price', 'date'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function land() {
        return $this->belongsTo(Land::class);
    }

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'price' => 'integer'
    ];
}
