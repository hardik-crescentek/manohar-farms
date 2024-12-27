<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'company', 'category', 'designation', 'phone'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
}
