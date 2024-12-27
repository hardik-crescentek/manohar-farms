<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vehicles_and_attachments';

    protected $fillable = ['type', 'name', 'number', 'documents', 'image','service_cycle_type','vehicle_notification'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'documents' => 'array',
    ];
}
