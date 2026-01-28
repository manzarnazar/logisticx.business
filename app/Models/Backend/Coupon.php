<?php

namespace App\Models\Backend;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $casts = [
        'mid'               => 'json',
    ];


    public function getTypeBadgeAttribute()
    {
        $type = $this->type ? config('site.coupon_types.' . $this->type) : 'unknown';

        $classes = [
            CouponType::COMMON->value           => 'success',
            CouponType::MERCHANT_WISE->value    => 'info',
        ];

        $class = $classes[$this->type] ?? 'danger';

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("common.{$type}") . "</span>";
    }

    public function getDiscountTypeBadgeAttribute()
    {
        $type = $this->discount_type ? config('site.discount_types.' . $this->discount_type) : 'unknown';

        $classes = [
            DiscountType::FIXED->value      => 'info',
            DiscountType::PERCENT->value    => 'success',
        ];

        $class = $classes[$this->discount_type] ?? 'danger';

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("common.{$type}") . "</span>";
    }


    public function getDiscountTextAttribute()
    {
        if ($this->discount_type == DiscountType::FIXED->value) {
            return settings('currency') . ' ' . $this->discount;
        }

        if ($this->discount_type == DiscountType::PERCENT->value) {
            return  '% ' . $this->discount;
        }

        return $this->discount;
    }
}
