<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAttendance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'staff_member_id',
        'attendance_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'attendance_date' => 'date',
        'status' => 'integer',
    ];

    /**
     * Get the staff associated with the attendance.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    /**
     * Get the staff member associated with the attendance.
     */
    public function staffMember()
    {
        return $this->belongsTo(StaffMember::class, 'staff_member_id');
    }
}
