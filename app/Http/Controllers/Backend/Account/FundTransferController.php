<?php

namespace App\Http\Controllers\Backend\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FundTransfer\StoreRequest;
use App\Http\Requests\FundTransfer\UpdateRequest;
use App\Models\Backend\FundTransfer;
use App\Repositories\FundTransfer\FundTransferInterface;
use App\Repositories\Account\AccountInterface;
use Brian2694\Toastr\Facades\Toastr;

class FundTransferController extends Controller
{
    protected $repo, $account;
    public function __construct(FundTransferInterface $repo, AccountInterface $account)
    {
        $this->repo    = $repo;
        $this->account = $account;
    }

    public function index(Request $request)
    {
        $fund_transfers = $this->repo->all();
        $accounts       = $this->account->all();
        return view('backend.fund_transfer.index', compact('fund_transfers', 'request', 'accounts'));
    }

    public function create()
    {
        $accounts = $this->repo->accounts();
        return view('backend.fund_transfer.create', compact('accounts'));
    }

    public function store(StoreRequest $request)
    {
        $result = $this->repo->store($request);
        if ($result['status']) {
            return redirect()->route('fund-transfer.index')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }

    public function edit($id)
    {
        $accounts = $this->repo->accounts();
        $fund_transfer = $this->repo->get($id);
        $account = $this->account->get($fund_transfer->from_account);
        $current_balance = $account->balance + $fund_transfer->amount;
        return view('backend.fund_transfer.edit', compact('fund_transfer', 'accounts', 'current_balance'));
    }

    public function update($id, UpdateRequest $request)
    {

        $result = $this->repo->update($id, $request);
        if ($result['status']) {
            return redirect()->route('fund-transfer.index')->with('success', $result['message']);
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


    public function fundTransferSpecificSearch(Request $request)
    {
        $fund_transfers = $this->repo->fundTransferSearch($request)->paginate(settings('paginate_value'));
        $search         = $this->repo->fundTransferSearch($request)->get()->pluck('id')->toArray();
        $accounts       = $this->account->all();
        return view('backend.fund_transfer.index', compact('fund_transfers', 'request', 'search', 'accounts'));
    }

    public function fundTransferSearchFilterPrint(Request $request)
    {

        $fund_transfers = FundTransfer::whereIn('id', $request->ids)->get();
        return view('backend.fund_transfer.print', compact('fund_transfers'));
    }

    public function fundTransferFilter(Request $request)
    {
        $fund_transfers = $this->repo->fundTransferFilter($request)->paginate(settings('paginate_value'));
        $search         = $this->repo->fundTransferFilter($request)->get()->pluck('id')->toArray();
        $accounts       = $this->account->all();
        return view('backend.fund_transfer.index', compact('fund_transfers', 'request', 'search', 'accounts'));
    }
}
