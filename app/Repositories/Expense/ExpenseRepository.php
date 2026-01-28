<?php

namespace App\Repositories\Expense;

use App\Repositories\Expense\ExpenseInterface;
use App\Models\Backend\Expense;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\AccountHead;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Enums\AccountHeads;
use App\Enums\FixedAccountHeads;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Models\Backend\DeliveryHeroCommission;
use App\Repositories\Upload\UploadInterface;

class ExpenseRepository implements ExpenseInterface
{

    use ReturnFormatTrait;

    private $model, $uploadRepo;

    public function __construct(Expense $model, UploadInterface $uploadRepo)
    {
        $this->model        = $model;
        $this->uploadRepo   = $uploadRepo;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::with('deliveryman', 'deliveryman.user', 'account')->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function filter($request, string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::with('merchant', 'merchant.user', 'deliveryman', 'deliveryman.user', 'account', 'parcel')->where(function ($query) use ($request) {
            if ($request->account_head_id) {
                $query->where('account_head_id', $request->account_head_id);
            }
            if ($request->account_id) {
                $query->where('account_id', $request->account_id);
            }
            if ($request->date) :
                if ($request->date) {
                    $query->where(['date' => date('Y-m-d', strtotime($request->date))]);
                }
            endif;
        })->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {

        try {
            DB::beginTransaction();


            $account = Account::find($request->account_id);
            if ($account->balance < $request->amount) {
                return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
            }
            $account->balance               = $account->balance - $request->amount;
            $account->save();

            // Add Transactions
            $transaction                    = new BankTransaction();
            $transaction->account_id       = $account->id;
            $transaction->type             = AccountHeads::EXPENSE;
            $transaction->amount           = $request->amount;
            $transaction->date             = date('Y-m-d H:i:s');
            $transaction->note             = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
            $transaction->save();

            // handel Account and Transactions if PayToHub
            if ($request->account_head_id == FixedAccountHeads::PayToHub) {
                // update account balance
                $account                      = Account::find($request->hub_account_id);
                $account->balance             = $account->balance + $request->amount;
                $account->save();

                // Handle Income transaction
                $incomeTransaction                   = new BankTransaction();
                $incomeTransaction->account_id       = $account->id;
                $incomeTransaction->type             = AccountHeads::INCOME;
                $incomeTransaction->amount           = $request->amount;
                $incomeTransaction->date             = date('Y-m-d H:i:s');
                $incomeTransaction->note             = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
                $incomeTransaction->save();
            }

            // Handle expense table
            $expense                        = new $this->model;
            $expense->account_head_id       = $request->account_head_id;
            $expense->amount                = $request->amount;
            $expense->date                  = $request->date;
            $expense->receipt               = $this->uploadRepo->uploadImage($request->file('receipt'), 'receipt', [], null);
            $expense->note                  = $request->note;
            $expense->account_id            = $request->account_id;
            $expense->bank_transaction_id        = $transaction->id;

            if ($request->account_head_id == FixedAccountHeads::PayToHub) {
                $expense->to_bank_transaction_id = $incomeTransaction->id;
            }

            if ($request->delivery_man_id) {
                $expense->delivery_man_id   = $request->delivery_man_id;
            }

            if ($request->hub_id) {
                $expense->hub_id            = $request->hub_id;
            }

            if ($request->hub_account_id) {
                $expense->hub_account_id    = $request->hub_account_id;
            }

            if ($request->title) {
                $expense->title            = $request->title;
            }

            $expense->save();

            // Handle Hero commission
            if ($request->account_head_id == FixedAccountHeads::PayDeliveryManCommission) {
                $commissionIds =  DeliveryHeroCommission::where('delivery_hero_id', $request->delivery_man_id)->orWhere('pickup_hero_id', $request->delivery_man_id)->whereIn('parcel_id', $request->parcel_id)->pluck('id');
                foreach ($commissionIds as $id) {
                    $heroCommission                     = DeliveryHeroCommission::find($id);
                    $heroCommission->expense_id         = $expense->id;
                    $heroCommission->payment_status     = PaymentStatus::PAID;
                    $heroCommission->status             = Status::ACTIVE;
                    $heroCommission->save();
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('expense.index'), 'status_code' => '201']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $expense                        =  $this->model::find($request->id);

            $transaction                    =  BankTransaction::find($expense->bank_transaction_id);

            // reverse old account balance
            $account = Account::find($expense->account_id);
            $account->balance = $account->balance + $expense->amount;
            $account->save();

            // handle new account  balance
            $account = Account::find($request->account_id);
            if ($account->balance < $request->amount) {
                return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
            }
            $account->balance               = $account->balance - $request->amount;
            $account->save();

            // Update Transaction
            $transaction->account_id       = $account->id;
            $transaction->type             = AccountHeads::EXPENSE;
            $transaction->amount           = $request->amount;
            $transaction->date             = date('Y-m-d H:i:s');
            $transaction->note             = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
            $transaction->save();

            // handel Account and Transactions if PayToHub
            if ($request->account_head_id == FixedAccountHeads::PayToHub) {

                // reverse old account balance
                $account = Account::find($expense->hub_account_id);
                if ($account->balance < $request->amount) {
                    return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
                }
                $account->balance = $account->balance - $expense->amount;
                $account->save();

                // update new account balance
                $account                      = Account::find($request->hub_account_id);
                $account->balance             = $account->balance + $request->amount;
                $account->save();

                // Update Income transaction
                $incomeTransaction                   = BankTransaction::find($expense->to_bank_transaction_id);
                $incomeTransaction->account_id       = $account->id;
                $incomeTransaction->type             = AccountHeads::INCOME;
                $incomeTransaction->amount           = $request->amount;
                $incomeTransaction->date             = date('Y-m-d H:i:s');
                $incomeTransaction->note             = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
                $incomeTransaction->save();
            }

            // Handle expense table
            $expense->account_head_id       = $request->account_head_id;
            $expense->amount                = $request->amount;
            $expense->date                  = $request->date;
            $expense->receipt               = $this->uploadRepo->uploadImage($request->file('receipt'), 'receipt', [], $expense->receipt);
            $expense->note                  = $request->note;
            $expense->account_id            = $request->account_id;
            $expense->bank_transaction_id        = $transaction->id;

            if ($request->account_head_id == FixedAccountHeads::PayToHub) {
                $expense->to_bank_transaction_id = $incomeTransaction->id;
            }

            if ($request->delivery_man_id) {
                $expense->delivery_man_id   = $request->delivery_man_id;
            }

            if ($request->hub_id) {
                $expense->hub_id            = $request->hub_id;
            }

            if ($request->hub_account_id) {
                $expense->hub_account_id    = $request->hub_account_id;
            }

            if ($request->title) {
                $expense->title            = $request->title;
            }

            $expense->save();

            // Handle Hero commission
            if ($request->account_head_id == FixedAccountHeads::PayDeliveryManCommission) {
                $commissionIds =  DeliveryHeroCommission::where('delivery_hero_id', $request->delivery_man_id)->orWhere('pickup_hero_id', $request->delivery_man_id)->whereIn('parcel_id', $request->parcel_id)->pluck('id');
                foreach ($commissionIds as $id) {
                    $heroCommission                     = DeliveryHeroCommission::find($id);
                    $heroCommission->expense_id         = $expense->id;
                    $heroCommission->payment_status     = PaymentStatus::PAID;
                    $heroCommission->status             = Status::ACTIVE;
                    $heroCommission->save();
                }

                $oldCommissionIds =  DeliveryHeroCommission::where('expense_id', $expense->id)->whereNotIn('parcel_id', $request->parcel_id)->pluck('id');
                foreach ($oldCommissionIds as $id) {
                    $heroCommission                     = DeliveryHeroCommission::find($id);
                    $heroCommission->expense_id         = null;
                    $heroCommission->payment_status     = PaymentStatus::UNPAID;
                    $heroCommission->save();
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('expense.index'), 'status_code' => '201']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $expense        = $this->model::find($id);
            // reverse old account balance
            $account = Account::find($expense->account_id);
            $account->balance = $account->balance + $expense->amount;
            $account->save();

            if ($expense->hub_account_id) {
                $account = Account::find($expense->hub_account_id);
                $account->balance = $account->balance - $expense->amount;
                $account->save();

                $transaction    = BankTransaction::find($expense->to_bank_transaction_id);
                $transaction->delete();
            }

            $transaction    = BankTransaction::find($expense->bank_transaction_id);
            $transaction->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
