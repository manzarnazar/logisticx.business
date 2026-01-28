<?php

namespace App\Http\Controllers\Backend;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Repositories\Bank\BankInterface;
use App\Repositories\MerchantPayment\PaymentInterface;

class MerchantPaymentAccountController extends Controller
{
    protected $repo,   $bankRepo;

    public function __construct(PaymentInterface $payRepo, BankInterface $bankRepo)
    {
        $this->repo = $payRepo;
        $this->bankRepo = $bankRepo;
    }

    public function index($merchant_id)
    {
        $accounts   = $this->repo->all(merchant_id: $merchant_id,  paginate: settings('paginate_value'));
        return view('backend.merchant.payment.index', compact('merchant_id', 'accounts'));
    }

    public function create($merchant_id)
    {
        $banks    = $this->bankRepo->all(Status::ACTIVE, orderBy: 'bank_name');
        return view('backend.merchant.payment.create', compact('banks', 'merchant_id'));
    }

    public function edit($merchant_id, $id)
    {
        $account    = $this->repo->get($id);
        $banks    = $this->bankRepo->all(Status::ACTIVE, orderBy: 'bank_name');
        return view('backend.merchant.payment.edit', compact('account', 'banks', 'merchant_id'));
    }

    // payment information store
    public function store(PaymentInfoStore $request)
    {
        $result = $this->repo->store($request);

        if ($result['status']) {
            return redirect()->route('merchant.paymentInfo.index', $request->merchant_id)->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    // payment information update
    public function update(PaymentInfoStore $request)
    {
        $result = $this->repo->update($request);

        if ($result['status']) {
            return redirect()->route('merchant.paymentInfo.index', $request->merchant_id)->with('success', $result['message']);
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
