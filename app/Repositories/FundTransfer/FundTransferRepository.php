<?php

namespace App\Repositories\FundTransfer;

use App\Models\Backend\FundTransfer;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Traits\ReturnFormatTrait;
use App\Repositories\FundTransfer\FundTransferInterface;
use App\Enums\AccountHeads;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FundTransferRepository implements FundTransferInterface
{

    use ReturnFormatTrait;
    private $model;

    public function __construct(FundTransfer $model)
    {
        $this->model = $model;
    }

    public function all($orderBy = 'id', $sortBy = 'desc')
    {
        return  $this->model::orderBy($orderBy, $sortBy)->with('fromAccount', 'fromAccount.user', 'fromAccount.user.upload', 'toAccount', 'toAccount.user', 'toAccount.user.upload')->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function accounts()
    {
        return Account::all();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            // check balance in from account and minus balance
            $from_account = Account::find($request->from_account);
            if ($from_account->balance < $request->amount) {
                return $this->responseWithError(___('account.not_enough_balance'), []);
            } elseif ($request->amount <= 0) {
                return $this->responseWithError(___('account.more_than_0tk'), []);
            }
            $from_account->balance              = $from_account->balance - $request->amount;
            $from_account->save();
            // add balance in to account
            $to_account = Account::find($request->to_account);
            $to_account->balance                = $to_account->balance + $request->amount;
            $to_account->save();
            // add row fund transter
            $fund_transfer                      = new $this->model;
            $fund_transfer->from_account        = $request->from_account;
            $fund_transfer->to_account          = $request->to_account;
            $fund_transfer->amount              = $request->amount;
            $fund_transfer->date                = $request->date;
            $fund_transfer->description         = $request->description;
            $fund_transfer->save();
            // add row bank transactions (expense)
            $transaction                        = new BankTransaction();
            $transaction->fund_transfer_id      = $fund_transfer->id;
            $transaction->account_id            = $request->from_account;
            $transaction->type                  = AccountHeads::EXPENSE;
            $transaction->amount                = $request->amount;
            $transaction->date                  = $request->date;
            $transaction->note                  = ___('account.expense');
            $transaction->save();
            // add row bank transactions (income)
            $transaction                        = new BankTransaction();
            $transaction->fund_transfer_id      = $fund_transfer->id;
            $transaction->account_id            = $request->to_account;
            $transaction->type                  = AccountHeads::INCOME;
            $transaction->amount                = $request->amount;
            $transaction->date                  = $request->date;
            $transaction->note                  = ___('account.income');
            $transaction->save();
            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {

            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            // select fund transfer row
            $fund_transfer                 = $this->model::find($id);
            // return balance from account
            $from_account                  = Account::find($fund_transfer->from_account);
            $from_account->balance         = $from_account->balance + $fund_transfer->amount;
            $from_account->save();
            // minus balance to account
            $to_account                    = Account::find($fund_transfer->to_account);
            $to_account->balance           = $to_account->balance - $fund_transfer->amount;
            $to_account->save();
            // delete transaction rows
            $transactions                  = BankTransaction::where('fund_transfer_id', $fund_transfer->id)->pluck('id')->all();
            BankTransaction::whereIn('id', $transactions)->delete();
            // from account check balance and minus balance
            $from_account                  = Account::find($request->from_account);
            if ($from_account->balance < $request->amount) {
                return $this->responseWithError(___('account.not_enough_balance'), []);
            } elseif ($request->amount <= 0) {
                return $this->responseWithError(___('account.more_than_0tk'), []);
            }
            $from_account->balance         = $from_account->balance - $request->amount;
            $from_account->save();
            // To account add balance
            $to_account                    = Account::find($request->to_account);
            $to_account->balance           = $to_account->balance + $request->amount;
            $to_account->save();
            // fund transfer row update
            $fund_transfer->from_account   = $request->from_account;
            $fund_transfer->to_account     = $request->to_account;
            $fund_transfer->amount         = $request->amount;
            $fund_transfer->date           = $request->date;
            $fund_transfer->description    = $request->description;
            $fund_transfer->save();
            // add row bank transactions (expense)
            $transaction                   = new BankTransaction();
            $transaction->fund_transfer_id = $fund_transfer->id;
            $transaction->account_id       = $request->from_account;
            $transaction->type             = AccountHeads::EXPENSE;
            $transaction->amount           = $request->amount;
            $transaction->date             = $request->date;
            $transaction->note             = ___('account.expense');
            $transaction->save();
            // add row bank transactions (income)
            $transaction                   = new BankTransaction();
            $transaction->fund_transfer_id = $fund_transfer->id;
            $transaction->account_id       = $request->to_account;
            $transaction->type             = AccountHeads::INCOME;
            $transaction->amount           = $request->amount;
            $transaction->date             = $request->date;
            $transaction->note             = ___('account.income');
            $transaction->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            // select fund transfer row
            $fund_transfer         = $this->model::find($id);
            // return balance in from account
            $from_account          = Account::find($fund_transfer->from_account);
            $from_account->balance = $from_account->balance + $fund_transfer->amount;
            $from_account->save();
            // minus balance in to account
            $to_account            = Account::find($fund_transfer->to_account);
            $to_account->balance   = $to_account->balance - $fund_transfer->amount;
            $to_account->save();
            // delete transactions row
            $transactions          = BankTransaction::where('fund_transfer_id', $fund_transfer->id)->pluck('id')->all();
            BankTransaction::whereIn('id', $transactions)->delete();
            // delete fund transfer row
            $fund_transfer->delete();
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function fundTransferSearch($request)
    {
        return  $this->model::whereHas('fromAccount', function ($query) use ($request) {
            $query->where('account_holder_name', 'Like', '%' . $request->search . '%');
            $query->orWhere('account_no', 'Like', '%' . $request->search . '%');
            $query->orWhere('branch_name', 'Like', '%' . $request->search . '%');
            $query->orWhere('mobile', 'Like', '%' . $request->search . '%');
            $query->orWhere('account_type', 'Like', '%' . $request->search . '%');
            $query->orWhereHas('user', function ($query) use ($request) {
                $query->where('name', 'Like', '%' . $request->search . '%');
            });
        })
            ->orWhereHas('toAccount', function ($query) use ($request) {
                $query->where('account_holder_name', 'Like', '%' . $request->search . '%');
                $query->orWhere('account_no', 'Like', '%' . $request->search . '%');
                $query->orWhere('branch_name', 'Like', '%' . $request->search . '%');
                $query->orWhere('mobile', 'Like', '%' . $request->search . '%');
                $query->orWhere('account_type', 'Like', '%' . $request->search . '%');
                $query->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'Like', '%' . $request->search . '%');
                });
            });
    }

    public function fundTransferFilter($request)
    {
        return $this->model::orderByDesc('id')->where(function ($query) use ($request) {
            if ($request->date) {
                $date = explode('to', $request->date);
                if (is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('updated_at', [$from, $to]);
                }
            }
            if (!blank($request->from_account)) :
                $query->where('from_account', $request->from_account);
            endif;

            if (!blank($request->to_account)) :
                $query->where('to_account', $request->to_account);
            endif;
        });
    }
}
