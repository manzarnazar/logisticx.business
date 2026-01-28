<?php

namespace App\Http\Controllers\Backend\MerchantManage;

use App\Enums\CashCollectionStatus;
use App\Enums\ParcelStatus;
use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Models\Backend\Payment;
use App\Models\MerchantPayment;
use App\Models\Backend\Merchant;
use App\Traits\ReturnFormatTrait;
use App\Http\Controllers\Controller;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Http\Requests\MerchantManage\Payment\StoreRequest;
use App\Http\Requests\MerchantManage\Payment\ProcessRequest;
use App\Models\MerchantPaymentPivot;
use App\Repositories\MerchantManage\Payment\PaymentInterface;

class MerchantManagePaymentController extends Controller
{
    use ReturnFormatTrait;

    protected $merchant;
    protected $account;
    protected $payment;

    public function __construct(MerchantInterface $merchant, AccountInterface $account, PaymentInterface $payment)
    {
        $this->merchant = $merchant;
        $this->account  = $account;
        $this->payment  = $payment;
    }

    public function index(Request $request)
    {
        $payments = $this->payment->all();
        $accounts = $this->account->all();
        return view('backend.merchantmanage.payment.index', compact('payments', 'request', 'accounts'));
    }

    public function view($id)
    {
        $payment    = $this->payment->get($id);
        return view('backend.merchantmanage.payment.view', compact('payment'));
    }

    public function create()
    {
        $merchants = $this->merchant->all(status: Status::ACTIVE);
        $accounts  = $this->account->getAdminAccounts();
        return view('backend.merchantmanage.payment.create', compact('merchants', 'accounts'));
    }


    public function merchantAccount(Request $request)
    {
        $merchantAccounts = MerchantPayment::where('merchant_id', $request->merchant_id)->get();


        $accounts = "<option selected disabled>" . ___('menus.select') . ' ' . ___('merchant.merchant') . ' ' . ___('account.accounts') . "</option>";

        foreach ($merchantAccounts as $account) {
            if ($account->payment_method == 'bank') {
                $accounts .= "<option value='" . $account->id . "'>" . $account->bank_name . ' | ' . $account->account_name  . ' | ' . $account->account_no . ' | ' . $account->branch_name . "</option>";
            } elseif ($account->payment_method == 'mfs') {
                $accounts .= "<option value='" . $account->id . "'>" . $account->mfs . ' | ' . $account->mobile_no . '|' . $account->account_type . "</option>";
            } elseif ($account->payment_method == 'cash') {
                $accounts .= "<option value='" . $account->id . "'>" . ___('merchant.' . $account->payment_method) . "</option>";
            }
        }

        return response()->json($accounts);
    }

    function unpaidParcels(Request $request)
    {
        if (!request()->ajax()) {
            return response()->json(['message' => ___('alert.invalid_request')], 422);
        }

        if ($request->merchant_id == null) {
            return response()->json(['message' => 'Merchant id can not be null.'], 422);
        }

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->where('merchant_id', $request->merchant_id);
        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);
        $query->doesntHave('merchantPaymentPivot');

        $parcels = $query->get(['id', 'merchant_id', 'delivery_date', 'tracking_id', 'status',]);

        if ($parcels->isEmpty()) {
            return response()->json(['message' => 'No Parcels found'], 404);
        }

        return response()->json($parcels);
    }

    public function merchantSearch(Request $request)
    {
        $search         = $request->search;
        if ($search == '') {
            $merchants  = [];
        } else {
            $merchants  = Merchant::where('status', Status::ACTIVE)->orderby('business_name', 'asc')->select('id', 'business_name')->where('business_name', 'like', '%' . $search . '%')->limit(10)->get();
        }
        $response = [];
        foreach ($merchants as $merchant) {
            $response[] = array(
                "id"    => $merchant->id,
                "text"  => $merchant->business_name,
            );
        }
        return response()->json($response);
    }


    //payment store
    public function paymentStore(StoreRequest $request)
    {
        $result = $this->payment->store($request);
        if ($result['status']) {
            return redirect()->route('merchant.manage.payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    //edit
    public function edit($id)
    {
        $singlePayment    = $this->payment->get($id);
        $merchants        = $this->merchant->all(status: Status::ACTIVE);
        $accounts         = $this->account->getAdminAccounts();
        $merchantAccounts = MerchantPayment::where('merchant_id', $singlePayment->merchant_id)->get();

        $pivotParcelsIds = MerchantPaymentPivot::where('payment_id', $singlePayment->id)->pluck('parcel_id');

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge');
        $query->where('merchant_id', $singlePayment->merchant_id);
        $query->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true));
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);
        // $query->doesntHave('merchantPaymentPivot');
        $parcels = $query->get(['id', 'merchant_id', 'delivery_date', 'tracking_id', 'status',]);

        // dd($parcels);

        return view('backend.merchantmanage.payment.edit', compact('singlePayment', 'merchants', 'accounts', 'merchantAccounts', 'parcels', 'pivotParcelsIds'));
    }

    public function update(StoreRequest $request)
    {
        $result = $this->payment->update($request);
        if ($result['status']) {
            return redirect()->route('merchant.manage.payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function destroy($id)
    {
        if ($this->payment->delete($id)) :
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

    //process section
    public function reject($id)
    {
        $result = $this->payment->reject($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
    public function cancelReject($id)
    {
        $result = $this->payment->cancelReject($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
    public function process($id)
    {
        $payment  = Payment::where('id', $id)->first();
        $accounts = $this->account->all();
        return view('backend.merchantmanage.payment.process', compact('payment', 'accounts'));
    }

    public function cancelProcess($id)
    {
        $result = $this->payment->cancelProcess($id);
        if ($result['status']) {
            return back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function processed(ProcessRequest $request)
    {
        $result = $this->payment->processed($request);
        if ($result['status']) {
            return redirect()->route('merchant.manage.payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function merchantpaymentFilter(Request $request)
    {
        $payments = $this->payment->filter($request);
        $accounts = $this->account->all();
        $merchant = $this->merchant->get($request->merchant_id);
        if ($request->merchant_id) :
            $merchantaccounts = MerchantPayment::where('merchant_id', $request->merchant_id)->get();
        else :
            $merchantaccounts = null;
        endif;
        return view('backend.merchantmanage.payment.index', compact('payments', 'request', 'accounts', 'merchantaccounts', 'merchant'));
    }
}
