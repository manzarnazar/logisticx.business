<?php

namespace App\Models\Backend;

use App\Models\User;
use App\Enums\UserType;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportChat extends Model
{
    use HasFactory, CommonHelperTrait;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function file()
    {
        return $this->belongsTo(Upload::class, 'attached_file', 'id');
    }

    public function support()
    {
        return $this->belongsTo(Support::class, 'support_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function getuserTypeAttribute()
    {
        $typeMappings = [
            UserType::ADMIN       => ___("common.admin"),
            UserType::MERCHANT    => ___("common.merchant"),
            UserType::DELIVERYMAN => ___("common.deliveryman"),
            UserType::INCHARGE    => ___("common.in_charge"),
            UserType::HUB         => ___("common.hub")
        ];

        return $typeMappings[$this->user->user_type] ?? null;
    }
}
