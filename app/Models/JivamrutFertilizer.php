<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JivamrutFertilizer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jivamrut_fertilizer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'ingredients',
        'ingredients_value',
        'date',
        'barrels',
    ];

    protected $casts = [
        'date' => 'datetime:d-m-Y',
        'ingredients' => 'array',
        'ingredients_value' => 'array'
    ];

    public function removedBarrels()
    {
        return $this->hasMany(JivamrutBarrel::class, 'jivamrut_fertilizer_id')->where('status', 1);
    }

    public function barrelsCount()
    {
        return $this->hasMany(JivamrutBarrel::class, 'jivamrut_fertilizer_id')->where('status', 0);
    }

    public function addBarrelsSum()
    {
        $sum = $this->barrelsCount()->sum('barrel_qty');
        return (int) $sum;
    }

    public function removeBarrelsCount()
    {
        return $this->hasMany(JivamrutBarrel::class, 'jivamrut_fertilizer_id')->where('status', 1);
    }

    public function removeBarrelsSum()
    {
        $sum = $this->removeBarrelsCount()->sum('barrel_qty');
        return (int) $sum;
    }


}
