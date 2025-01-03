<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JivamrutEntry extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jivamrut_entries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'land_id',
        'land_part_id',
        'size',
        'barrels',
        'date',
        'time',
        'person',
        'volume',
        'notes',
    ];

    public function land() {
        return $this->belongsTo(Land::class);
    }

    public function landPart() {
        return $this->belongsTo(LandPart::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'land_part_id' => 'array'
    ];

}
