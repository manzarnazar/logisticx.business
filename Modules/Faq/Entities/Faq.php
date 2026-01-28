<?php

namespace Modules\Faq\Entities;

use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faq extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];

    // public function getMyStatusAttribute()
    // {
    //     if($this->status == Status::INACTIVE)
    //         return '<span class="badge badge-pill badge-warning">'.__('inactive').'</span>';
    //     elseif($this->status == Status::ACTIVE)
    //         return '<span class="badge badge-pill badge-success">'.__('active').'</span>';
    // }
}
