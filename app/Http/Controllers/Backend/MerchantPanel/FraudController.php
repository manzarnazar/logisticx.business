<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MerchantPanel\Fraud\StoreRequest;
use App\Http\Requests\MerchantPanel\Fraud\UpdateRequest;
use App\Repositories\MerchantPanel\Fraud\FraudInterface;

class FraudController extends Controller
{
    protected $repo;
    public function __construct(FraudInterface $repo)
    {
        $this->repo = $repo;
    }
    public function index()
    {
        $frauds = $this->repo->all();
        return view('backend.merchant_panel.fraud.index', compact('frauds'));
    }

    public function filter()
    {
        $frauds = $this->repo->filter();
        return view('backend.merchant_panel.fraud.index', compact('frauds'));
    }
    public function check(Request $request)
    {
        $frauds = $this->repo->check($request);
        return view('backend.merchant_panel.fraud.index', compact('frauds'));
    }
    public function create()
    {
        return view('backend.merchant_panel.fraud.create');
    }
    public function store(StoreRequest $request)
    {
        if ($this->repo->store($request)) {
            toast(___('alert.successfully_added'), 'success');
            return redirect()->route('merchant-panel.fraud.index');
        } else {
            toast(___('alert.something_went_wrong'), 'error');
            return redirect()->back();
        }
    }
    public function edit($id)
    {
        $fraud = $this->repo->get($id);
        return view('backend.merchant_panel.fraud.edit', compact('fraud'));
    }

    public function update(UpdateRequest $request)
    {
        if ($this->repo->update($request->id, $request)) {
            toast(___('alert.successfully_updated'), 'success');
            return redirect()->route('merchant-panel.fraud.index');
        } else {
            toast(___('alert.something_went_wrong'), 'error');
            return redirect()->back();
        }
    }
    public function destroy($id)
    {
        $this->repo->delete($id);
        toast(___('alert.successfully_deleted'), 'success');
        return back();
    }
}
