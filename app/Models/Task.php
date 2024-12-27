<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'title', 'status', 'date'];

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
    ];

    public function getDateAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d', $value)->format('d-m-Y') : null;
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
