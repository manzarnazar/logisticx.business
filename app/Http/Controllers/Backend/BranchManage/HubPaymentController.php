<?php

namespace App\Http\Controllers\Backend\BranchManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\HubManage\Payment\HubPaymentRequest;
use App\Http\Requests\HubManage\Payment\ProcessRequest;
use App\Models\Backend\HubPayment;
use App\Repositories\Account\AccountInterface;
use App\Repositories\Hub\HubInterface;
use App\Repositories\HubManage\HubPayment\HubPaymentInterface;

class HubPaymentController extends Controller
{

    protected $hub;
    protected $account;
    protected $payment;

    public function __construct(
        AccountInterface $account,
        HubInterface $hub,
        HubPaymentInterface $payment
    ) {
        $this->account = $account;
        $this->payment = $payment;
        $this->hub     = $hub;
    }
    public function index()
    {
        $payments = $this->payment->all(paginate: settings('paginate_value'));
        return view('backend.hub_payment.index', compact('payments'));
    }

    public function create()
    {
        $hubs        = $this->hub->all();
        $accounts    = $this->account->all();
        return view('backend.hub_payment.create', compact('hubs', 'accounts'));
    }

    //payment store
    public function paymentStore(HubPaymentRequest $request)
    {
        $result = $this->payment->store($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    //edit
    public function edit($id)
    {
        $payment    = $this->payment->get($id);
        $hubs       = $this->hub->all();
        return view('backend.hub_payment.edit', compact('payment', 'hubs'));
    }

    public function update(HubPaymentRequest $request)
    {
        $result = $this->payment->update($request);

        if ($request->wantsJson()) {
            return response()->json($result, $result['data']['status_code']);
        }

        if ($result['status']) {
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function delete($id)
    {
        $result = $this->payment->delete($id);

        if ($result['status']) :
            $success[0] = $result['message'];
            $success[1] = 'success';
            $success[2] = ___('delete.deleted');
            return response()->json($success);
        else :
            $success[0] = $result['message'];
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
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function cancelReject($id)
    {
        $result = $this->payment->cancelReject($id);

        if ($result['status']) {
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function process($id)
    {
        try {
            $payment  = HubPayment::findOrFail($id);
            $accounts = $this->account->all();
            return view('backend.hub_payment.process', compact('payment', 'accounts'));
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    public function cancelProcess($id)
    {
        $result = $this->payment->cancelProcess($id);

        if ($result['status']) {
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function processed(ProcessRequest $request)
    {
        $result = $this->payment->processed($request);

        if ($result['status']) {
            return redirect()->route('hub.hub-payment.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
