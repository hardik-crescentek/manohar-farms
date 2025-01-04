<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlotFertilizer extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'plot_fertilizers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'land_id',
        'land_part_id',
        'fertilizer_name',
        'quantity',
        'date',
        'time',
        'volume',
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
