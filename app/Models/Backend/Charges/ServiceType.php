<?php

namespace App\Models\Backend\Charges;

use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory, CommonHelperTrait;
}
