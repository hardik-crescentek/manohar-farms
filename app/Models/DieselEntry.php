<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DieselEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['vehicle_id', 'volume', 'payment_person', 'amount', 'date', 'notes'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
