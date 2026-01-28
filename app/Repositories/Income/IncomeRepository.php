<?php

namespace App\Repositories\Income;

use App\Models\User;
use App\Enums\UserType;
use App\Enums\AccountHeads;
use App\Enums\CashCollectionStatus;
use App\Models\Backend\Hub;
use App\Models\Backend\Income;
use App\Models\Backend\Parcel;
use App\Models\Backend\Account;
use App\Enums\FixedAccountHeads;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Models\Backend\Merchant;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\AccountHead;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\DeliveryHeroCommission;
use App\Models\Backend\IncomeParcelPivot;
use App\Repositories\Income\IncomeInterface;
use App\Repositories\Upload\UploadInterface;

class IncomeRepository implements IncomeInterface
{
    use ReturnFormatTrait;

    private $model, $uploadRepo;

    public function __construct(Income $model, UploadInterface $uploadRepo)
    {
        $this->model        = $model;
        $this->uploadRepo   = $uploadRepo;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::with('merchant', 'merchant.user', 'deliveryman', 'deliveryman.user', 'account', 'parcels')->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function filter($request, string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::with('merchant', 'merchant.user', 'deliveryman', 'deliveryman.user', 'account', 'parcels')->where(function ($query) use ($request) {
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

    public function accountHeads(string $orderBy = 'id', string $sortBy = 'asc')
    {
        return AccountHead::where('type', AccountHeads::INCOME)->orderBy($orderBy, $sortBy)->get();
    }

    public function get($id)
    {
        return $this->model::with('parcels')->findOrFail($id);
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();

            $transaction                   = new BankTransaction();

            $transaction->account_id       = $request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan ? $request->hub_account_id : $request->account_id;

            $transaction->type             = AccountHeads::INCOME;
            $transaction->amount           = $request->amount;
            $transaction->date             = date('Y-m-d H:i:s');
            $transaction->note             = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
            $transaction->to_head_id       = $request->account_head_id;
            $transaction->save();

            // update account balance
            $account                      = Account::find($transaction->account_id);
            $account->balance             = $account->balance + $request->amount;
            $account->save();


            // Handle Expense transaction
            if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
                $expanseTransaction                 = new BankTransaction();
                $expanseTransaction->account_id     = $request->hub_account_id;
                $expanseTransaction->type           = AccountHeads::EXPENSE;
                $expanseTransaction->amount         = $request->amount;
                $expanseTransaction->date           = date('Y-m-d H:i:s');
                $expanseTransaction->note           = $request->title ? $request->title : 'PaidToAdmin';
                $expanseTransaction->to_head_id     = FixedAccountHeads::PaidToAdmin;
                $expanseTransaction->save();

                // update account balance
                $account            = Account::find($request->hub_account_id);
                if ($account->balance < $request->amount) {
                    DB::rollBack();
                    return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
                }
                $account->balance   = $account->balance - $request->amount;
                $account->save();
            }

            // handle income
            $income                             = new $this->model;
            $income->account_head_id            = $request->account_head_id; // always
            $income->amount                     = $request->amount; // always
            $income->date                       = $request->date;   // always
            $income->receipt                    = $this->uploadRepo->uploadImage($request->file('receipt'), 'receipt', [], null); // always
            $income->note                       = $request->input('note'); // always
            $income->account_id                 = $transaction->account_id;
            $income->bank_transaction_id        = $transaction->id;

            if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
                $income->from_bank_transaction_id    = $expanseTransaction->id;
            }

            if ($request->delivery_man_id) {
                $income->delivery_man_id        = $request->delivery_man_id; //conditional
            }

            if ($request->hub_id) {
                $income->hub_id                 = $request->hub_id; //conditional
            }

            if ($request->hub_account_id) {
                $income->hub_account_id         = $request->hub_account_id; //conditional
            }

            if ($request->merchant_id) {
                $income->merchant_id            = $request->merchant_id; //conditional
            }

            $income->title                       = $request->input('title'); // conditional
            $income->save();

            // handle IncomeParcelPivot
            if ($request->parcel_id) {
                foreach ($request->parcel_id as $parcel_id) {

                    // handle income pivot
                    $pivot              = new IncomeParcelPivot();
                    $pivot->income_id   = $income->id;
                    $pivot->parcel_id   = $parcel_id;
                    $pivot->save();

                    // handle hero commission
                    if ($request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan) {

                        $parcel = Parcel::with('charge')->find($parcel_id);

                        $heroCharge = $parcel->charge->delivery_commission;

                        if ($parcel->quantity > 1) {
                            $heroCharge +=   ($parcel->quantity - 1) * $parcel->charge->additional_delivery_commission;
                        }

                        $heroCommission                     = new DeliveryHeroCommission();
                        $heroCommission->delivery_hero_id   =  $request->delivery_man_id;
                        $heroCommission->amount             =  $heroCharge;
                        $heroCommission->parcel_id          =  $parcel_id;
                        $heroCommission->payment_status     =  PaymentStatus::UNPAID;
                        $heroCommission->status             =  Status::ACTIVE;
                        $heroCommission->save();
                    }
                }

                if ($request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan) {
                    Parcel::whereIn('id', $request->parcel_id)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_HUB]);
                }

                if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
                    Parcel::whereIn('id', $request->parcel_id)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_ADMIN]);
                }

                if ($request->account_head_id == FixedAccountHeads::ReceiveFromMerchant) {
                    Parcel::whereIn('id', $request->parcel_id)->update(['is_charge_paid' =>  true]);
                }
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('income.index'), 'status_code' => '201']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function update($request)
    {
        // try {
        DB::beginTransaction();

        $income                         =  $this->model::findOrFail($request->id);

        // update transaction
        $transaction                    = BankTransaction::findOrFail($income->bank_transaction_id);
        $transaction->account_id        = $request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan ? $request->hub_account_id : $request->account_id;
        $transaction->type              = AccountHeads::INCOME;
        $transaction->amount            = $request->amount;
        $transaction->date              = date('Y-m-d H:i:s');
        $transaction->note              = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
        $transaction->to_head_id        = $request->account_head_id;
        $transaction->save();

        // reverse old account balance
        $account = Account::find($income->account_id);
        if ($account->balance   < $income->amount) {
            DB::rollBack();
            return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
        }
        $account->balance = $account->balance - $income->amount;
        $account->save();

        // update account balance
        $account                        = Account::find($transaction->account_id);
        $account->balance               = $account->balance + $request->amount;
        $account->save();

        // Handle Expense transaction
        if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
            $expanseTransaction                = BankTransaction::findOrFail($income->from_bank_transaction_id);;
            $expanseTransaction->account_id    = $request->hub_account_id;
            $expanseTransaction->type          = AccountHeads::EXPENSE;
            $expanseTransaction->amount        = $request->amount;
            $expanseTransaction->date          = date('Y-m-d H:i:s');
            $transaction->to_head_id           = $request->account_head_id;
            $expanseTransaction->note          = $request->title ? $request->title : AccountHead::find($request->account_head_id)->name;
            $expanseTransaction->to_head_id    = FixedAccountHeads::PaidToAdmin;
            $expanseTransaction->save();

            // reverse old account balance
            $account = Account::find($income->hub_account_id);
            $account->balance = $account->balance + $income->amount;
            $account->save();

            // update account balance
            $account            = Account::find($request->hub_account_id);
            if ($account->balance < $request->amount) {
                DB::rollBack();
                return $this->responseWithError(__('account.not_enough_balance'), ['status_code' => '406']);
            }
            $account->balance   = $account->balance - $request->amount;
            $account->save();
        }


        // handle income
        $income->account_head_id            = $request->account_head_id;
        $income->amount                     = $request->amount;
        $income->date                       = $request->date;
        $income->receipt                    = $this->uploadRepo->uploadImage($request->file('receipt'), 'receipt', [],  $income->receipt);
        $income->note                       = $request->note;
        $income->account_id                 = $transaction->account_id;
        $income->bank_transaction_id        = $transaction->id;

        if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
            $income->from_bank_transaction_id    = $expanseTransaction->id;
        }

        if ($request->delivery_man_id) {
            $income->delivery_man_id        = $request->delivery_man_id; //conditional
        }

        if ($request->hub_id) {
            $income->hub_id                 = $request->hub_id; //conditional
        }

        if ($request->hub_account_id) {
            $income->hub_account_id         = $request->hub_account_id; //conditional
        }

        if ($request->merchant_id) {
            $income->merchant_id            = $request->merchant_id; //conditional
        }

        $income->title                      = $request->input('title'); // conditional
        $income->save();

        // handle IncomeParcelPivot
        if ($request->parcel_id) {

            // dd($request->parcel_id);

            foreach ($request->parcel_id as $parcel_id) {
                // handle Income pivot
                $pivot =   IncomeParcelPivot::where('income_id', $income->id)->where('parcel_id', $parcel_id)->exists();
                if (!$pivot) {
                    $pivot              = new IncomeParcelPivot();
                    $pivot->income_id   = $income->id;
                    $pivot->parcel_id   = $parcel_id;
                    $pivot->save();
                }

                // handle hero commission
                if ($request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan) {

                    $heroCommission = DeliveryHeroCommission::where('parcel_id', $parcel_id)->first();

                    if (!$heroCommission || $heroCommission->payment_status != PaymentStatus::PAID) {
                        $parcel = Parcel::with('charge')->find($parcel_id);

                        $heroCharge = $parcel->charge->delivery_commission;
                        if ($parcel->quantity > 1) {
                            $heroCharge +=   ($parcel->quantity - 1) * $parcel->charge->additional_delivery_commission;
                        }

                        if (!$heroCommission) {
                            $heroCommission                 = new DeliveryHeroCommission();
                            $heroCommission->parcel_id      = $parcel_id;
                            $heroCommission->payment_status = PaymentStatus::UNPAID;
                        }

                        $heroCommission->amount             = $heroCharge;
                        $heroCommission->delivery_hero_id   = $request->delivery_man_id;
                        $heroCommission->status             = Status::ACTIVE;
                        $heroCommission->save();
                    }
                }
            }

            $PivotParcelIdsNotInRequest = IncomeParcelPivot::where('income_id', $income->id)->whereNotIn('parcel_id', $request->parcel_id)->pluck('parcel_id');
            IncomeParcelPivot::where('income_id', $income->id)->whereIn('parcel_id', $PivotParcelIdsNotInRequest)->delete(); // delete

            if ($request->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan) {
                $parcel = Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN)->get();
                if (!$parcel->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.some_parcels_already_received_by_admin'), ['status_code' => '406']);
                }
                Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->update(['cash_collection_status' => CashCollectionStatus::PENDING]); // back to previous state

                Parcel::whereNot('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN)->whereIn('id', $request->parcel_id)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_HUB]); // update
            }

            if ($request->account_head_id == FixedAccountHeads::ReceiveFromHub) {
                $parcel = Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT)->get();
                if (!$parcel->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.some_parcels_already_received_by_merchant'), ['status_code' => '406']);
                }
                Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_HUB]); // back to previous state
                Parcel::whereNot('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT)->whereIn('id', $request->parcel_id)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_ADMIN]); // update
            }

            if ($request->account_head_id == FixedAccountHeads::ReceiveFromMerchant) {
                $parcel = Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->where('is_charge_paid', true)->get();
                if (!$parcel->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.some_parcels_already_charge_paid'), ['status_code' => '406']);
                }
                Parcel::whereIn('id', $PivotParcelIdsNotInRequest)->update(['is_charge_paid' =>  false]); // back to previous state
                Parcel::whereIn('id', $request->parcel_id)->update(['is_charge_paid' =>  true]); // update
            }
        }

        DB::commit();
        return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('income.index'), 'status_code' => '201']);
        // } catch (\Throwable $th) {
        //     DB::rollBack();
        //     return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        // }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $income = $this->model::find($id);

            $this->uploadRepo->deleteImage($income->receipt, 'delete');

            if ($income->account_head_id == FixedAccountHeads::ReceiveFromDeliveryMan) {
                $parcelsIds = IncomeParcelPivot::where('income_id', $income->id)->get('parcel_id');
                $parcels = Parcel::whereIn('id', $parcelsIds)->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN)->get();
                if (!$parcels->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.something_went_wrong'), []);
                }
                Parcel::whereIn('id', $parcelsIds)->update(['cash_collection_status' => CashCollectionStatus::PENDING]); // back to previous state
            }

            if ($income->account_head_id == FixedAccountHeads::ReceiveFromHub) {
                $parcelsIds = IncomeParcelPivot::where('income_id', $income->id)->get('parcel_id');
                $parcels = Parcel::whereIn('id', $parcelsIds)->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT)->get();
                if (!$parcels->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.something_went_wrong'), []);
                }
                Parcel::whereIn('id', $parcelsIds)->update(['cash_collection_status' => CashCollectionStatus::RECEIVED_BY_ADMIN]); // back to previous state
            }

            if ($income->account_head_id == FixedAccountHeads::ReceiveFromMerchant) {
                $parcelsIds = IncomeParcelPivot::where('income_id', $income->id)->get('parcel_id');
                $parcels    = Parcel::whereIn('id', $parcelsIds)->where('is_charge_paid',  true)->get();
                if (!$parcels->isEmpty()) {
                    DB::rollBack();
                    return $this->responseWithError(___('alert.something_went_wrong'), []);
                }
                Parcel::whereIn('id', $parcelsIds)->update(['is_charge_paid' => false]); // back to previous state
            }

            // reverse old account balance
            $account            = Account::find($income->account_id);
            $account->balance   = $account->balance - $income->amount;
            $account->save();

            if ($income->hub_account_id) {
                $account            = Account::find($income->hub_account_id);
                $account->balance   = $account->balance + $income->amount;
                $account->save();
            }

            if ($income->from_bank_transaction_id) {
                $transaction    = BankTransaction::find($income->from_bank_transaction_id);
                $transaction->delete();
            }

            $transaction    = BankTransaction::find($income->bank_transaction_id);
            $transaction->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function hubCheck($request)
    {

        if ($request->from     == 1) :
            return $user    = Merchant::find($request->merchant);
        elseif ($request->from == 2) :
            return $user    = DeliveryMan::find($request->deliveryman);
        elseif ($request->from == FixedAccountHeads::ReceiveFromHub) :
            return $user    = Hub::find($request->hub);
        else :
            return $user    = null;
        endif;
    }
    public function hubUserAccounts($request)
    {

        return Account::where('user_id', $request->id)->get();
    }
    public function hubUsers($id)
    {
        return User::where('hub_id', $id)->where('user_type', UserType::ADMIN)->get();
    }
}
