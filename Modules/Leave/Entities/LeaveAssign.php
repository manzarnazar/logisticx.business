<?php

namespace Modules\Leave\Entities;

use App\Traits\CommonHelperTrait;
use App\Models\Backend\Department;
use Modules\Leave\Entities\LeaveType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveAssign extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Leave\Database\factories\LeaveAssignFactory::new();
    // }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    // public function leaveTypes()
    // {
    //     return $this->belongsTo(LeaveType::class, 'type_id', 'id');
    // }

    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'type_id', 'id');
    }
}
