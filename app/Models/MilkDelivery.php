<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MilkDelivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'milk_deliveries';

    protected $fillable = ['customer_id', 'date', 'milk'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $casts = [
        'milk' => 'integer',
    ];
}
