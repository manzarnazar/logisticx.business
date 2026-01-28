<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteList extends Model
{
    use HasFactory;


    public function getMyStatusAttribute()
    {
        if ($this->status == Status::ACTIVE) {
            $status = '<span class="badge badge-pill badge-success">' . trans("status." . $this->status) . '</span>';
        } else {
            $status = '<span class="badge badge-pill badge-danger">' . trans("status." . $this->status) . '</span>';
        }
        return $status;
    }
}
