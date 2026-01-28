<?php

namespace App\Models\Backend\Setting;

use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupSlot extends Model
{
    use HasFactory, CommonHelperTrait;
}
