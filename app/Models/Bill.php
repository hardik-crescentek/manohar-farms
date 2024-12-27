<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'image',
        'land_id',
        'payment_person',
        'period_start',
        'period_end',
        'amount',
        'due_date',
        'status'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function land() {
        return $this->belongsTo(Land::class);
    }

    protected $casts = [
        'due_date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
