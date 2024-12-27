<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GheeSelling extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image', 'customer_id', 'customer_name', 'quantity', 'price', 'total', 'date', 'note',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
