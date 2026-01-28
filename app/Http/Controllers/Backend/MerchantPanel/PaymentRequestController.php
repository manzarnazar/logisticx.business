<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\MerchantPanel\PaymentRequest\StoreRequest;
use App\Models\MerchantPayment;
use App\Repositories\MerchantManage\Payment\PaymentInterface;
use Illuminate\Support\Facades\Auth;
use App\Enums\ApprovalStatus;
use App\Enums\CashCollectionStatus;
use App\Enums\ParcelStatus;
use App\Enums\UserType;
use App\Models\Backend\Parcel;
use App\Models\MerchantPaymentPivot;

class PaymentRequestController extends Controller
{
    protected $repo;

    public function __construct(PaymentInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $payments = $this->repo->all(Auth::user()->merchant->id);
        return view('backend.merchant_panel.payment_request.index', compact('payments'));
    }

    public function create()
    {
        $mid = auth()->user()->merchant->id;

        $accounts = MerchantPayment::where('merchant_id', $mid)->get();

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->where('merchant_id', $mid);
        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);
        $query->doesntHave('merchantPaymentPivot');

        $parcels = $query->get(['id', 'merchant_id', 'delivery_date', 'tracking_id', 'status',]);

        if ($parcels->isEmpty()) {
            return back()->with('danger', ___('alert.no_parcel_found'));
        }

        return view('backend.merchant_panel.payment_request.create', compact('accounts', 'parcels'));
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['merchant' => auth()->user()->merchant->id, 'created_by' => UserType::MERCHANT]);

        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('merchant-panel.payment-request.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message'])->withInput();
    }

    public function edit($id)
    {
        $paymentRequest    = $this->repo->get($id);

        if ($paymentRequest->status != ApprovalStatus::PENDING) {
            return back()->with('danger', ___('alert.modification_not_allowed'));
        }

        $accounts = MerchantPayment::where('merchant_id', $paymentRequest->merchant_id)->get();

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->where('merchant_id', $paymentRequest->merchant_id);
        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);
        $parcels = $query->get(['id', 'merchant_id', 'delivery_date', 'tracking_id', 'status',]);

        return view('backend.merchant_panel.payment_request.edit', compact('paymentRequest', 'accounts', 'parcels'));
    }

    public function update(StoreRequest $request)
    {
        $request->merge(['merchant' => auth()->user()->merchant->id, 'created_by' => UserType::MERCHANT]);

        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('merchant-panel.payment-request.index')->with('success', $result['message']);
        }

        return back()->with('danger', $result['message'])->withInput();
    }

    public function delete($id)
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
}
