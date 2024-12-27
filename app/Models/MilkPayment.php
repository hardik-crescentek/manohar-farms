<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkPayment extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'image', 'milk', 'amount', 'date', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
