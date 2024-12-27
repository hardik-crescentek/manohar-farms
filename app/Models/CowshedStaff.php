<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CowshedStaff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'is_leader',
        'role',
        'name',
        'phone',
        'email',
        'address',
        'salary',
        'rate_per_day',
        'joining_date',
        'resign_date',
    ];

    protected $dates = ['deleted_at'];
}
