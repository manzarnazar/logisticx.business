<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Repositories\Bank\BankInterface;
use App\Repositories\MerchantPayment\PaymentInterface;

class PaymentAccountController extends Controller
{
    protected $repo, $bankRepo;

    public function __construct(PaymentInterface $repo, BankInterface $bankRepo)
    {
        $this->repo = $repo;
        $this->bankRepo = $bankRepo;
    }

    public function index()
    {
        $accounts = $this->repo->all(paginate: settings('paginate_value'));
        return view('backend.merchant_panel.payment_account.index', compact('accounts'));
    }

    public function create()
    {
        $banks    = $this->bankRepo->all(Status::ACTIVE, orderBy: 'bank_name');
        return view('backend.merchant_panel.payment_account.create', compact('banks'));
    }

    public function edit($id)
    {
        $account  = $this->repo->get($id);
        $banks    = $this->bankRepo->all(Status::ACTIVE, orderBy: 'bank_name');
        return view('backend.merchant_panel.payment_account.edit', compact('account', 'banks'));
    }
}
