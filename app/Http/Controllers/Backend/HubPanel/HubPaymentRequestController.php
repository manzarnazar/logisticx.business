<?php

namespace App\Http\Controllers\Backend\HubPanel;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\HubPaymentRequest\StoreRequest;
use App\Repositories\HubManage\HubPayment\HubPaymentInterface;

class HubPaymentRequestController extends Controller
{
    protected $repo;

    public function __construct(HubPaymentInterface $repo)
    {
        $this->repo  = $repo;
    }

    public function index()
    {
        $payments = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.hub_panel.hub_payment_request.index', compact('payments'));
    }

    public function create()
    {
        return view('backend.hub_panel.hub_payment_request.create');
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['hub_id' => auth()->user()->hub_id, 'created_by' => UserType::INCHARGE]);

        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('hub-panel.payment-request.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $singlePayment      =   $this->repo->get($id);
        return view('backend.hub_panel.hub_payment_request.edit', compact('singlePayment'));
    }

    public function update(StoreRequest $request,)
    {
        $request->merge(['hub_id' => auth()->user()->hub_id, 'created_by' => UserType::INCHARGE]);

        $result = $this->repo->update($request);
        if ($result['status']) {
            return redirect()->route('hub-panel.payment-request.index')->with('success', $result['message']);
        }
        return redirect()->back()->withInput()->with('danger', $result['message']);
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
            $success[0] = $result['message'];
            $success[1] = 'error';
            $success[2] = ___('delete.oops');
            return response()->json($success);
        endif;
    }
}
