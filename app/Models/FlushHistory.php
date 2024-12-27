<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlushHistory extends Model
{
    use HasFactory;

    protected $table = 'flush_history';

    protected $fillable = [
        'user_id',
        'land_id',
        'land_part_id',
        'date',
        'person',
        'note',
    ];

    protected $dates = ['date', 'created_at', 'updated_at'];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'land_part_id' => 'array'
    ];

    public function landPartNames()
    {
        return LandPart::whereIn('id', $this->land_part_id)->pluck('name')->toArray();
    }
}
