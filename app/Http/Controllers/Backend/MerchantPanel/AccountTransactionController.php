<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\AccountHeads;
use App\Http\Controllers\Controller;
use App\Models\Backend\BankTransaction;
use Illuminate\Http\Request;
use App\Models\Backend\Payment;
use App\Models\MerchantPayment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AccountTransactionController extends Controller
{

    public function index()
    {
        $mid = Auth::user()->merchant->id;

        $accounts = MerchantPayment::where('merchant_id', $mid)->get();

        $query = BankTransaction::query();
        $query->whereHas('income', fn($query) => $query->where('merchant_id', $mid));
        $query->orWhereHas('merchantPayment', fn($query) => $query->where('merchant_id', $mid));
        $transactions =   $query->paginate(settings('paginate_value'));

        return view('backend.merchant_panel.account_transaction.index', compact('accounts', 'transactions'));
    }


    public function filter(Request $request)
    {
        $mid = Auth::user()->merchant->id;

        $accounts = MerchantPayment::where('merchant_id', $mid)->get();

        $query = BankTransaction::query();
        $query->with('merchantPayment');
        $query->whereHas('merchantPayment', fn($query) => $query->where('merchant_id', $mid));

        if ($request->date) {
            $date = explode('to', $request->date);
            if (is_array($date)) {
                $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                $to     = isset($date[1]) ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString() : Carbon::parse(trim($date[0]))->endOfDay()->toDateTimeString();
                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        if ($request->type) {
            $type = $request->type == AccountHeads::INCOME ? AccountHeads::EXPENSE : AccountHeads::INCOME;
            $query->where('type', $type);
        }

        if ($request->account) {
            $query->whereHas('merchantPayment', fn($query) => $query->where('merchant_account', $request->account));
        }

        $transactions =   $query->paginate(settings('paginate_value'));

        return view('backend.merchant_panel.account_transaction.index', compact('accounts', 'transactions'));
    }
}
