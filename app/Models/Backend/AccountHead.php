<?php

namespace App\Models\Backend;

use ReflectionClass;
use App\Enums\AccountHeads;
use App\Enums\FixedAccountHeads;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountHead extends Model
{
    use HasFactory, CommonHelperTrait;

    public static function protectedIds(): array
    {
        $reflection = new ReflectionClass(FixedAccountHeads::class);
        return array_values($reflection->getConstants());
    }

    protected static function booted()
    {
        static::deleting(function ($accountHead) {
            if (in_array($accountHead->id, self::protectedIds())) {
                throw new \Exception(___('alert.delete_not_allowed'), 1403);
            }
        });

        static::updating(function ($accountHead) {
            if (in_array($accountHead->id, self::protectedIds())) {
                throw new \Exception(___('alert.update_not_allowed'), 1403);
            }
        });
    }

    public function getMyTypeAttribute()
    {
        $type = null;
        if ($this->type      == AccountHeads::INCOME) {
            $type = '<span class="bullet-badge bullet-badge-success">' . ___('account.income') . '</span>';
        } else {
            $type = '<span class="bullet-badge bullet-badge-danger">' . ___('account.expense') . '</span>';
        }

        return $type;
    }
}
