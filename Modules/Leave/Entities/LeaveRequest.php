<?php

namespace Modules\Leave\Entities;

use App\Models\User;
use App\Models\Backend\Upload;
use App\Models\Backend\Department;
use Modules\Leave\Entities\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Modules\Leave\Entities\LeaveAssign;
use Modules\Leave\Enums\LeaveRequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [];


    public function leaveTypes()
    {
        return $this->belongsTo(LeaveType::class, 'type_id', 'id');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'file_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function getDateAttribute()
    // {
    //     if ($this->attributes['to_date'] != null) {
    //         return $this->attributes['from_date'] . ' to ' . $this->attributes['to_date'];
    //     }

    //     return $this->attributes['from_date'];
    // }

    public function getLeaveRequestStatusAttribute()
    {
        $status = '';

        if ($this->status == LeaveRequestStatus::PENDING) {
            $status = '<span class="bullet-badge bullet-badge-warning">' . ___("hr_manage." . config('site.status.hr_leave.' . $this->status)) . '</span>';
        } elseif ($this->status == LeaveRequestStatus::REJECTED) {
            $status = '<span class="bullet-badge bullet-badge-danger">' . ___("hr_manage." . config('site.status.hr_leave.' . $this->status)) . '</span>';
        } elseif ($this->status == LeaveRequestStatus::APPROVED) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___("hr_manage." . config('site.status.hr_leave.' . $this->status)) . '</span>';
        } else {
            $status = '<span class="bullet-badge bullet-badge-danger">' . trans("label.unknown") . '</span>';
        }

        return $status;
    }

    public function getAvailableDaysAttribute()
    {
        $departmentId = $this->attributes['department_id'] ?? null;
        $typeId = $this->attributes['type_id'] ?? null;

        $days = LeaveAssign::where('department_id', $departmentId)->where('type_id', $typeId)->value('days');

        return $days;
    }


    public function getTotalLeaveAttribute()
    {
        $user = auth()->user();
        $departmentId = $user->department_id;

        // Fetch the assigned days for each type of leave in the user's department
        $assignedDays = LeaveAssign::where('department_id', $departmentId)
            ->pluck('days', 'type_id')
            ->toArray();

        return $assignedDays;
    }
}
