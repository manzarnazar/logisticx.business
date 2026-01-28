<?php

namespace App\Http\Controllers\Backend;

use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreRequest;
use App\Http\Requests\Coupon\UpdateRequest;
use App\Models\Backend\Coupon;
use App\Models\Backend\Merchant;
use App\Repositories\Coupon\CouponInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    private $repo;

    public function __construct(CouponInterface $repo)
    {
        $this->repo          = $repo;
    }

    public function index()
    {
        $coupons = $this->repo->all(paginate: settings('paginate_value'));

        return view('backend.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('backend.coupon.create');
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('coupon.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $coupon     = $this->repo->get($id);
        $merchants  = Merchant::whereIn('id', $coupon->mid)->get(['id', 'business_name']);
        return view('backend.coupon.edit', compact('coupon', 'merchants'));
    }

    public function update(UpdateRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('coupon.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function delete($id)
    {
        $result = $this->repo->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = ___('alert.something_went_wrong');
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }


    // json response 
    public function apply(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }
        if ($request->coupon == null) {
            return response()->json(['message' =>   ___('charges.coupon_code_required')], 404);
        }

        $coupon = Coupon::where('coupon', $request->input('coupon'))->where('status', Status::ACTIVE)->where('end_date', '>=', Carbon::now())->first();

        if ($coupon == null) {
            return response()->json(['message' =>  ___('charges.invalid_coupon')], 406);
        }

        $mid = $request->input('mid', Merchant::where('user_id', auth()->user()->id)->value('id'));

        if ($coupon->type == CouponType::MERCHANT_WISE->value && !in_array($mid, $coupon->mid)) {
            return response()->json(['message' =>  ___('charges.invalid_coupon')], 406);
        }

        $discount = $coupon->discount;

        if ($coupon->discount_type == DiscountType::PERCENT->value) {
            $discount = ($request->input('charge', 0) * $discount) / 100;
        }

        return response()->json(['verify' => true, 'discount' => $discount, 'message' => ___('charges.coupon_applied')]);
    }
}
