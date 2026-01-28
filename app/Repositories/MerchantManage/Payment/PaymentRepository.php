<?php

namespace App\Repositories\MerchantManage\Payment;

use App\Enums\AccountHeads;
use App\Enums\ApprovalStatus;
use App\Enums\CashCollectionStatus;
use App\Enums\UserType;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\Parcel;
use App\Models\Backend\Payment;
use App\Models\MerchantPaymentPivot;
use App\Repositories\MerchantManage\Payment\PaymentInterface;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class PaymentRepository implements PaymentInterface
{
    use ReturnFormatTrait;

    protected $model, $uploadRepo;

    public function __construct(Payment $model, UploadInterface $uploadRepo)
    {
        $this->model        = $model;
        $this->uploadRepo   = $uploadRepo;
    }

    public function all($merchant_id = null, string $orderBy = 'id', string $sortBy = 'desc', bool $get = false)
    {
        $query = $this->model::query();

        if ($merchant_id != null) {
            $query->where('merchant_id', $merchant_id);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($get) {
            $payments = $query->get();
            return $payments;
        }

        $payments =  $query->paginate(settings('paginate_value'));


        return $payments;
    }

    public function get($id)
    {
        return $this->model::with([
            'parcelPivot.parcel.parcelTransaction',  
            'merchant.user'                         
        ])->findOrFail($id);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            if ($request->isprocess) {
                // Handle Account Balance
                $account = Account::find($request->from_account);
                if ((float) $request->amount > $account->balance) {
                    return $this->responseWithSuccess(___('label.not_enough_courier_balance'), []);
                }
                $account->balance           = $account->balance - $request->amount;
                $account->save();

                //Handle bank transaction
                $transaction                =  new BankTransaction();
                $transaction->type          =  AccountHeads::EXPENSE;
                $transaction->account_id    =  $request->from_account;
                $transaction->amount        =  $request->amount;
                $transaction->date          =  date('Y-m-d H:i:s');
                $transaction->note          =  ___('label.merchant_payment_withdrawal');
                $transaction->save();
            }

            // Handle Payment- 
            $payment                          = new Payment();
            $payment->merchant_id             = $request->merchant;
            $payment->merchant_account        = $request->merchant_account;
            $payment->amount                  = $request->amount;
            $payment->description             = $request->description;
            $payment->created_by              = $request->created_by ?? UserType::ADMIN;
            $payment->status                  = ApprovalStatus::PENDING;

            // Handle is process
            if ($request->isprocess) {
                $payment->bank_transaction_id = $transaction->id;
                $payment->transaction_id      = $request->transaction_id;
                $payment->from_account        = $request->from_account;
                $payment->reference_file      = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], null);
                $payment->status              = ApprovalStatus::PROCESSED;
            }

            $payment->save();

            foreach ($request->parcel_id as $parcel_id) {
                $pivot              = new MerchantPaymentPivot();
                $pivot->payment_id  = $payment->id;
                $pivot->parcel_id   = $parcel_id;
                $pivot->save();
                //is process
                if ($request->isprocess) {
                    $parcel                         = Parcel::find($parcel_id);
                    $parcel->cash_collection_status = CashCollectionStatus::PAID_TO_MERCHANT->value;
                    $parcel->is_charge_paid         = true;
                    $parcel->save();
                }
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $payment    = $this->model::findOrFail($request->id);

            if ($payment->status != ApprovalStatus::PENDING) {
                return $this->responseWithError(___('alert.modification_not_allowed'), []);
            }

            // Adjust amount from account if is process
            if ($request->isprocess) {
                $account            = Account::find($request->from_account);
                // account balance check
                if ((float) $request->amount > $account->balance) {
                    return $this->responseWithSuccess(__('merchantmanage.not_enough_courier_balance'), []);
                }
                $account->balance   = $account->balance - $request->amount;
                $account->save();

                // Record Transaction
                $transaction                   =  new BankTransaction();
                $transaction->type             =  AccountHeads::EXPENSE;
                $transaction->account_id       =  $request->from_account;
                $transaction->amount           =  $request->amount;
                $transaction->date             =  date('Y-m-d H:i:s');
                $transaction->note             =  ___('merchantmanage.merchant_payment_withdrawal');
                $transaction->save();
            }

            $payment->merchant_id           = $request->merchant;
            $payment->merchant_account      = $request->merchant_account;
            $payment->amount                = $request->amount;
            $payment->status                = ApprovalStatus::PENDING;
            $payment->description           = $request->description;
            $payment->created_by            = $request->created_by ?? UserType::ADMIN;

            //is process
            if ($request->isprocess) {
                $payment->bank_transaction_id = $transaction->id;
                $payment->transaction_id      = $request->transaction_id;
                $payment->from_account        = $request->from_account;
                $payment->reference_file      = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], $payment->reference_file);
                $payment->status              = ApprovalStatus::PROCESSED;
            }

            $payment->save();

            // Handle MerchantPaymentPivot
            foreach ($request->parcel_id as $parcel_id) {
                $pivot              =  MerchantPaymentPivot::where('payment_id', $payment->id)->where('parcel_id', $parcel_id)->exists();
                if (!$pivot) {
                    $pivot              = new MerchantPaymentPivot();
                    $pivot->payment_id  = $payment->id;
                    $pivot->parcel_id   = $parcel_id;
                    $pivot->save();
                }
                // Update Parcel status if isprocess
                if ($request->isprocess) {
                    $parcel                         = Parcel::find($parcel_id);
                    $parcel->cash_collection_status = CashCollectionStatus::PAID_TO_MERCHANT->value;
                    $parcel->is_charge_paid         = true;
                    $parcel->save();
                }
            }

            // delete old parcel ids
            MerchantPaymentPivot::where('payment_id', $payment->id)->whereNot('parcel_id', $request->parcel_id)->delete();

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
            $payment = $this->model::find($id);

            if ($payment->status != ApprovalStatus::PENDING) {
                return $this->responseWithError(__('Delete not allowed.'), []);
            }

            $this->uploadRepo->deleteImage($payment->reference_file, 'delete');

            $payment->delete();

            return $this->responseWithSuccess(__('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $payment                   = $this->model::findOrFail($id);
            $payment->status           = ApprovalStatus::REJECT;
            $payment->save();
            DB::commit();

            return $this->responseWithSuccess(__('alert.successfully_rejected'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function cancelReject($id)
    {
        try {
            DB::beginTransaction();
            $payment                   = $this->model::where('id', $id)->first();
            $payment->status           = ApprovalStatus::PENDING;
            $payment->save();

            DB::commit();

            return $this->responseWithSuccess(__('alert.cancel_rejected_msg'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function processed($request)
    {
        try {

            DB::beginTransaction();

            $payment    = $this->model::findOrFail($request->id);

            $account    = Account::findOrFail($request->from_account);
            if ((float) $payment->amount > $account->balance) {
                return $this->responseWithSuccess(__('alert.not_enough_courier_balance'));
            }
            //minus amount from courier account
            $account->balance   = $account->balance - $payment->amount;
            $account->save();

            //bank transaction statements
            $bank_transaction                   =  new BankTransaction();
            $bank_transaction->account_id       =  $request->from_account;
            $bank_transaction->type             =  AccountHeads::EXPENSE;
            $bank_transaction->amount           =  $payment->amount;
            $bank_transaction->date             =  date('Y-m-d H:i:s');
            $bank_transaction->note             =  ___('alert.merchant_payment_withdrawal');
            $bank_transaction->save();

            // manage payment table
            $payment->bank_transaction_id       = $bank_transaction->id;
            $payment->transaction_id            = $request->transaction_id;
            $payment->from_account              = $request->from_account;
            $payment->reference_file            = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], $payment->reference_file);
            $payment->status                    = ApprovalStatus::PROCESSED;
            $payment->save();

            // Reverse Parcel status as cancel Process
            $parcelIds = MerchantPaymentPivot::where('payment_id', $payment->id)->pluck('id');
            foreach ($parcelIds as $parcel_id) {
                $parcel                         = Parcel::find($parcel_id);
                $parcel->cash_collection_status = CashCollectionStatus::PAID_TO_MERCHANT->value;
                $parcel->is_charge_paid         = true;
                $parcel->save();
            }

            DB::commit();

            return $this->responseWithSuccess(__('alert.processed_msg'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function cancelProcess($id)
    {
        try {
            DB::beginTransaction();

            $payment                   = $this->model::findOrFail($id);

            //plus amount from courier account
            $account                = Account::find($payment->from_account);
            $account->balance       = $account->balance + $payment->amount;
            $account->save();

            //bank transaction statements
            $transaction                   =  new BankTransaction();
            $transaction->account_id       =  $payment->from_account;
            $transaction->type             =  AccountHeads::INCOME;
            $transaction->amount           =  $payment->amount;
            $transaction->date             =  date('Y-m-d H:i:s');
            $transaction->note             =  ___('merchantmanage.merchant_payment_withdrawal');
            $transaction->save();

            $payment->status           = ApprovalStatus::PENDING;
            $payment->transaction_id   = null;
            $payment->from_account     = null;
            $payment->save();

            // Reverse Parcel status as cancel Process
            $parcelIds = MerchantPaymentPivot::where('payment_id', $payment->id)->pluck('id');
            foreach ($parcelIds as $parcel_id) {
                $parcel                         = Parcel::find($parcel_id);
                $parcel->cash_collection_status = CashCollectionStatus::RECEIVED_BY_ADMIN->value;
                $parcel->is_charge_paid         = false;
                $parcel->save();
            }

            DB::commit();

            return $this->responseWithSuccess(__('alert.cancel_processed_msg'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function filter($request)
    {
        return $this->model::where(function ($query) use ($request) {
            if ($request->date) {

                // $date = preg_split("/\bto\b/i", $request->date);
                $date = explode('to', $request->date);

                if (is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('updated_at', [$from, $to]);
                }
            }

            if ($request->merchant_id) {
                $query->where('merchant_id', $request->merchant_id);
            }
            if ($request->merchant_account) {
                $query->where('merchant_account', $request->merchant_account);
            }
            if ($request->from_account) {
                $query->where('from_account', $request->from_account);
            }
        })->paginate(settings('paginate_value'));
    }
}
