<?php

namespace App\Repositories\Coupon;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Backend\Coupon;
use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CouponRepository implements CouponInterface
{
    use ReturnFormatTrait;

    private $model;

    // private array $responseData = [];


    public function __construct(Coupon $model)
    {
        $this->model = $model;
    }

    public function all(array $column = [], int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        $query->orderBy($orderBy, $sortBy);

        if (!empty($column)) {
            $query->select($column);
        }

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function get($id)
    {
        return  $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $coupon                 = $this->model;
            $coupon->type           = $request->type;
            $coupon->mid            = $request->merchant_id ?? [];
            $coupon->start_date     = $request->start_date;
            $coupon->end_date       = $request->end_date;
            $coupon->discount_type  = $request->discount_type;
            $coupon->discount       = $request->discount;
            $coupon->coupon         = $request->coupon;
            $coupon->status         = $request->status ?? Status::INACTIVE;
            $coupon->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $coupon                 = $this->get($request->id);
            $coupon->type           = $request->type;
            $coupon->mid            = $request->merchant_id ?? [];
            $coupon->start_date     = $request->start_date;
            $coupon->end_date       = $request->end_date;
            $coupon->discount_type  = $request->discount_type;
            $coupon->discount       = $request->discount;
            $coupon->coupon         = $request->coupon;
            $coupon->status         = $request->status ?? Status::INACTIVE;
            $coupon->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function discount($coupon_code, $merchant_id, $charge)
    {
        $coupon = $this->model::where('coupon', $coupon_code)->where('status', Status::ACTIVE)->where('end_date', '>=', now())->first();

        if ($coupon == null || ($coupon->type == CouponType::MERCHANT_WISE->value && !in_array($merchant_id, $coupon->mid))) {
            return 0;
        }

        if ($coupon->discount_type == DiscountType::PERCENT->value) {
            return ($charge * $coupon->discount) / 100;
        }

        return $coupon->discount;
    }


}
