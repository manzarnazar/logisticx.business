<?php

namespace App\Http\Controllers\Backend\MerchantManage;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Backend\Merchant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\OtpRequest;
use App\Http\Requests\Merchant\SignUpRequest;
use App\Http\Requests\Merchant\MerchantStoreRequest;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Repositories\PickupSlot\PickupSlotInterface;

class MerchantController extends Controller
{
    protected $repo, $coverageRepo, $PickupSlotRepo;

    public function __construct(MerchantInterface $repo, CoverageInterface $coverageRepo, PickupSlotInterface $PickupSlotRepo)
    {
        $this->repo             = $repo;
        $this->coverageRepo     = $coverageRepo;
        $this->PickupSlotRepo     = $PickupSlotRepo;
    }

    public function index()
    {
        $merchants = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.merchant.index', compact('merchants'));
    }

    public function view($merchant_id)
    {
        $merchant = $this->repo->get($merchant_id);
        return view('backend.merchant.merchant-details', compact('merchant_id', 'merchant'));
    }

    public function create()
    {
        $hubs       = $this->repo->active_hubs();
        $coverages = $this->coverageRepo->getWithActiveChild();
        $pickupSlots = $this->PickupSlotRepo->all(Status::ACTIVE);

        return view('backend.merchant.create', compact('hubs', 'coverages', 'pickupSlots'));
    }

    public function store(MerchantStoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('merchant.index')->with('success', $result['message']);
        }
        return back()->withInput()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $merchant       = $this->repo->get($id);
        $hubs           = $this->repo->all_hubs();
        $coverages      = $this->coverageRepo->getWithActiveChild();
        $pickupSlots    = $this->PickupSlotRepo->all(Status::ACTIVE);

        return view('backend.merchant.edit', compact('merchant', 'hubs', 'coverages', 'pickupSlots'));
    }

    public function update(MerchantStoreRequest $request)
    {
        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('merchant.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function destroy($id)
    {
        if ($this->repo->delete($id)) :
            $success[0] = ___('alert.successfully_deleted');
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

    public function signUp(Request $request)
    {
        $hubs       = $this->repo->active_hubs();
        return view('frontend.pages.signup', compact('hubs'));
    }

    public function signUpStore(SignUpRequest $request)
    {
        $result = $this->repo->signUpStore($request);

        if ($result['status']) {
            return redirect()->route('signup.emailVerificationForm')->with('message', $result['message']);
        }
        return back()->withInput()->with('danger', $result['message']);
    }

    public function resendOTP(Request $request)
    {
        $result     = $this->repo->resendOTP($request);

        if ($request->expectsJson()) {
            return response()->json($result['data'], $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function emailVerificationForm()
    {
        if (session()->has('email')) {
            return view('frontend.pages.email_verification');
        }
        return redirect()->route('signin');
    }

    public function emailVerification(OtpRequest $request)
    {
        $result     = $this->repo->emailVerification($request);

        if ($result['status']) {
            if (auth()->attempt([
                'email' => $request->email,
                'password' => session('password')
            ])) {
                return redirect()->route('login');
            }
        }
        return redirect()->back()->with('danger', $result['message']);
    }

    public function otpVerification(OtpRequest $request)
    {
        $result     = $this->repo->otpVerification($request);

        if ($result != null) {
            if (auth()->attempt([
                'mobile' => $result->mobile,
                'password' => session('password')
            ])) {
                return redirect()->route('login');
            }
        } elseif ($result == 0) {
            return redirect()->route('merchant.otp-verification-form')->with('warning', 'Invalid OTP');
        } else {
            return redirect()->back()->with('danger', $result['message']);
        }
    }

    public function otpVerificationForm()
    {
        return view('backend.merchant.verification');
    }

    public function searchMerchant(Request $request)
    {
        $search   = $request->search;

        if (!request()->ajax()) {
            return response()->json(['error' => ___('alert.invalid_request')], 422);
        }

        if ($request->search == null) {
            return response()->json(['error' => 'search parameter can not be null.'], 422);
        }

        $merchants = Merchant::where('status', Status::ACTIVE)->where('business_name', 'like', '%' . $search . '%')->orderBy('business_name', 'asc')->take(10)->get(['id', 'business_name']);

        if ($merchants->isEmpty()) {
            return response()->json(['error' => 'No Merchant Found'], 422);
        }

        $response = $merchants->map(function ($merchant) {
            return [
                'id'   => $merchant->id,
                'text' => $merchant->business_name,
            ];
        })->toArray();

        return response()->json($response);
    }
}
