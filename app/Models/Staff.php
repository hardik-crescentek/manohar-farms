<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staffs';

    protected $fillable = [
        'image',
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
        'resign_date'
    ];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'joining_date' => 'datetime:d-m-Y',
        'resign_date' => 'datetime:d-m-Y',
        'salary' => 'integer',
        'rate_per_day' => 'integer',
    ];
}
