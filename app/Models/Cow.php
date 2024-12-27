<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'mother',
        'father',
        'gender',
        'tag_number',
        'age',
        'grade',
        'date',
        'remark',
        'milk',
        'image'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
    ];

    public function getGenderAttribute($value)
    {
        return $value == 1 ? 'Female' : 'Male';
    }

    public function fatherName()
    {
        return $this->belongsTo(Cow::class, 'father', 'id');
    }

    public function motherName()
    {
        return $this->belongsTo(Cow::class, 'mother', 'id');
    }

    public function children()
    {
        return $this->hasMany(Cow::class, 'mother', 'id');
    }
}
