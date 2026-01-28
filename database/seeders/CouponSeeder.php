<?php

namespace Database\Seeders;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Backend\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = collect($this->coupon());
        $coupons->each(fn ($coupon) => Coupon::create($coupon));
        // Coupon::insert($this->coupon());
    }

    private function coupon(): array
    {
        return [
            [
                'type'           => CouponType::COMMON,
                'mid'            => [],
                'start_date'     => date('Y-m-d'),
                'end_date'       => date('Y-m-d', strtotime('+10 days')),
                'discount_type'  => DiscountType::FIXED,
                'discount'       => 50,
                'coupon'         => 'COUPON6',
                'status'         =>  Status::ACTIVE,
            ],
            [
                'type'           => CouponType::MERCHANT_WISE,
                'mid'            => [1],
                'start_date'     => date('Y-m-d'),
                'end_date'       => date('Y-m-d', strtotime('+5 days')),
                'discount_type'  => DiscountType::PERCENT,
                'discount'       => 5,
                'coupon'         => 'COUPON5',
                'status'         =>  Status::ACTIVE,
            ],
            [
                'type'           => CouponType::MERCHANT_WISE,
                'mid'            => [1],
                'start_date'     => date('Y-m-d'),
                'end_date'       => date('Y-m-d', strtotime('+4 days')),
                'discount_type'  => DiscountType::FIXED,
                'discount'       => 140,
                'coupon'         => 'COUPON4',
                'status'         =>  Status::INACTIVE,
            ],
            [
                'type'           => CouponType::COMMON,
                'mid'            => [],
                'start_date'     => date('Y-m-d'),
                'end_date'       => date('Y-m-d', strtotime('+3 days')),
                'discount_type'  => DiscountType::PERCENT,
                'discount'       => 12,
                'coupon'         => 'COUPON3',
                'status'         =>  Status::INACTIVE,
            ],
            [
                'type'           => CouponType::COMMON,
                'mid'            => [],
                'start_date'     => date('Y-m-d', strtotime('-2 days')),
                'end_date'       => date('Y-m-d', strtotime('-1 days')),
                'discount_type'  => DiscountType::FIXED,
                'discount'       => 70,
                'coupon'         => 'COUPON2',
                'status'         =>  Status::INACTIVE,
            ],
            [
                'type'           => CouponType::MERCHANT_WISE,
                'mid'            => [1],
                'start_date'     => date('Y-m-d', strtotime('-3 days')),
                'end_date'       => date('Y-m-d', strtotime('-2 days')),
                'discount_type'  => DiscountType::PERCENT,
                'discount'       => 15,
                'coupon'         => 'COUPON1',
                'status'         =>  Status::ACTIVE,
            ],
        ];
    }
}
