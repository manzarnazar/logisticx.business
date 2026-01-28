<?php

namespace App\Http\Controllers\Backend\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Backend\BankTransaction;
use App\Repositories\Account\AccountInterface;
use App\Repositories\AccountHeads\AccountHeadsInterface;
use App\Repositories\BankTransaction\BankTransactionInterface;

class BankTransactionController extends Controller
{
    protected $repo, $account, $accountHeadsRepo;

    public function __construct(BankTransactionInterface $repo, AccountInterface $account, AccountHeadsInterface $accountHeadsRepo)
    {
        $this->repo             = $repo;
        $this->account          = $account;
        $this->accountHeadsRepo = $accountHeadsRepo;
    }

    public function index(Request $request)
    {
        $accounts       = $this->account->all();
        $transactions   = $this->repo->all();
        $accountHeads   = $this->accountHeadsRepo->getActive();
        return view('backend.bank_transaction.index', compact('accounts', 'transactions', 'request', 'accountHeads'));
    }

    public function filter(Request $request)
    {
        $transactions   = $this->repo->filter($request);
        $accounts       = $this->account->all();
        $accountHeads   = $this->accountHeadsRepo->getActive();
        return view('backend.bank_transaction.index', compact('accounts', 'transactions', 'request', 'accountHeads'));
    }

    public function bankTransactionPrint(Request $request)
    {
        $transactions   = BankTransaction::whereIn('id', $request->ids)->get();
        return view('backend.bank_transaction.transaction_print', compact('transactions'));
    }
}
