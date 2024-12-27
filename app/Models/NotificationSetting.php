<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'water',
        'fertiliser',
        'flushing',
        'Jivamrut',
        'vermi',
        'plots_filter_cleaning',
        'agenda_completion',
        'diesel',
        'created_at',
        'updated_at',
    ];
}
