<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JivamrutBarrel extends Model
{
    use HasFactory;

    protected $fillable = [
        'jivamrut_fertilizer_id',
        'name',
        'gaumutra',
        'worms',
        'water',
        'chokha',
        'god',
        'chana',
        'date',
        'status',
        'barrel_qty',
        'ingredients',
        'removed_date'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function fertilizer()
    {
        return $this->belongsTo(JivamrutFertilizer::class, 'jivamrut_fertilizer_id');
    }
}
