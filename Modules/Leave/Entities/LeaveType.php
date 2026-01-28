<?php

namespace Modules\Leave\Entities;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveType extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];

    // protected static function newFactory()
    // {
    //     return \Modules\Leave\Database\factories\LeaveTypeFactory::new();
    // }

}
