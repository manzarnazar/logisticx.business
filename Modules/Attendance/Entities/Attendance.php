<?php

namespace Modules\Attendance\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Attendance\Enums\AttendanceType;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Attendance\Database\factories\AttendanceFactory::new();
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getAttendanceTypeAttribute()
    {
        if ($this->type == AttendanceType::PRESENT) {
            $type = '<span class="bullet-badge bullet-badge-success">' . ___("label." . config('attendance.type.' . $this->type)) . '</span>';
        } elseif ($this->type == AttendanceType::LEAVE) {
            $type = '<span class="bullet-badge bullet-badge-info">' . ___("label." . config('attendance.type.' . $this->type)) . '</span>';
        } elseif ($this->type == AttendanceType::ABSENT) {
            $type = '<span class="bullet-badge bullet-badge-danger">' . ___("label." . config('attendance.type.' . $this->type)) . '</span>';
        } else {
            $type = '<span class="bullet-badge bullet-badge-danger">' . ___("label.unknown") . '</span>';
        }
        return $type;
    }
}
