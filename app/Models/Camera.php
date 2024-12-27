<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'image', 'camera_location', 'amount', 'purchase_date', 'memory_detail', 'sim_number', 'camera_company_name', 'service_company_name' , 'service_person_name', 'service_person_number', 'recharge_notification','last_cleaning_date'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'purchase_date' => 'datetime:d-m-Y',
        'amount' => 'integer',
    ];
}
