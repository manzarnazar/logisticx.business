<?php

namespace App\Repositories\HubManage\HubPayment;

use App\Enums\AccountHeads;
use App\Enums\ApprovalStatus;
use App\Enums\UserType;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\HubPayment;
use App\Models\Backend\Upload;
use App\Repositories\HubManage\HubPayment\HubPaymentInterface;
use App\Repositories\Upload\UploadInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class HubPaymentRepository implements HubPaymentInterface
{
    use ReturnFormatTrait;

    protected $model, $uploadRepo;

    public function __construct(HubPayment $model, UploadInterface $uploadRepo)
    {
        $this->model = $model;
        $this->uploadRepo   = $uploadRepo;
    }

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query =  $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        if (auth()->user()->user_type == UserType::INCHARGE) {
            $query->where('hub_id', auth()->user()->hub_id);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();

            $payment                        = new $this->model;
            $payment->hub_id                = $request->hub_id;
            $payment->hub_account_id        = $request->hub_account_id;
            $payment->amount                = $request->amount;
            $payment->description           = $request->description;
            $payment->created_by            = $request->created_by ?? UserType::ADMIN;
            $payment->status                = ApprovalStatus::PENDING;

            // handle if is process
            if ($request->isprocess) {
                $payment->transaction_id    = $request->transaction_id;
                $payment->from_account      = $request->from_account;
                $payment->status            = ApprovalStatus::PROCESSED;
                $payment->reference_file    = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], null);
            }

            $payment->save();

            // Manage bank transaction if is processed
            if ($request->isprocess) {
                // Handle Debited Account Balance
                $account = Account::find($request->from_account);
                if ($request->amount > $account->balance) {
                    return $this->responseWithSuccess(__('account.not_enough_balance'),  ['status_code' => '400']);
                }
                $account->balance           = $account->balance - $request->amount;
                $account->save();

                $transaction                = new BankTransaction();
                $transaction->account_id    = $request->from_account;
                $transaction->type          = AccountHeads::EXPENSE;
                $transaction->amount        = $request->amount;
                $transaction->date          = date('Y-m-d H:i:s');
                $transaction->note          = ___('hub.hub_payment_withdrawal');
                $transaction->save();

                // Handle Credited Account Balance
                $account                    = Account::find($request->hub_account_id);
                $account->balance           = $account->balance + $request->amount;
                $account->save();

                $transaction                = new BankTransaction();
                $transaction->account_id    = $request->hub_account_id;
                $transaction->type          = AccountHeads::INCOME;
                $transaction->amount        = $request->amount;
                $transaction->date          = date('Y-m-d H:i:s');
                $transaction->note          = ___('hub.hub_payment_withdrawal');
                $transaction->save();
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_added'), ['redirect_url' => route('hub.hub-payment.index'), 'status_code' => '201']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $payment                    = $this->model::findOrFail($request->id)->first();
            $payment->hub_id            = $request->hub_id;
            $payment->hub_account_id    = $request->hub_account_id;
            $payment->amount            = $request->amount;
            $payment->description       = $request->description;
            $payment->created_by        = $request->created_by ?? UserType::ADMIN;
            $payment->status            = ApprovalStatus::PENDING;

            // handle if is process
            if ($request->isprocess) {
                $payment->transaction_id = $request->transaction_id;
                $payment->from_account   = $request->from_account;
                $payment->status         = ApprovalStatus::PROCESSED;
                $payment->reference_file = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], $payment->reference_file);
            }

            $payment->save();

            // Manage bank transaction if is processed
            if ($request->isprocess) {
                // Handle Debited Account Balance
                $account = Account::find($request->from_account);
                if ($request->amount > $account->balance) {
                    return $this->responseWithSuccess(__('account.not_enough_balance'),  ['status_code' => '400']);
                }
                $account->balance           = $account->balance - $request->amount;
                $account->save();

                $transaction                = new BankTransaction();
                $transaction->account_id    = $request->from_account;
                $transaction->type          = AccountHeads::EXPENSE;
                $transaction->amount        = $request->amount;
                $transaction->date          = date('Y-m-d H:i:s');
                $transaction->note          = ___('hub.hub_payment_withdrawal');
                $transaction->save();

                // Handle Credited Account Balance
                $account                    = Account::find($request->hub_account_id);
                $account->balance           = $account->balance + $request->amount;
                $account->save();

                $transaction                = new BankTransaction();
                $transaction->account_id    = $request->hub_account_id;
                $transaction->type          = AccountHeads::INCOME;
                $transaction->amount        = $request->amount;
                $transaction->date          = date('Y-m-d H:i:s');
                $transaction->note          = ___('hub.hub_payment_withdrawal');
                $transaction->save();
            }

            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_updated'), ['redirect_url' => route('hub.hub-payment.index'), 'status_code' => '201']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $payment = $this->model::findOrFail($id);

            if ($payment->status != ApprovalStatus::PENDING) {
                return $this->responseWithError(___('alert.delete_not_allowed'), []);
            }

            if (auth()->user()->user_type == UserType::INCHARGE && $payment->created_by  != UserType::INCHARGE) {
                return $this->responseWithError(___('alert.delete_not_allowed'), []);
            }

            if ($payment->reference_file) {
                $this->uploadRepo->deleteImage($payment->reference_file, 'delete');
            }

            $payment->delete();
            DB::commit();

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function reject($id)
    {
        try {
            DB::beginTransaction();
            $payment                   = $this->model::findOrFail($id);
            if ($payment->status != ApprovalStatus::PENDING) {
                return $this->responseWithError(___('alert.modification_not_allowed'), []);
            }
            $payment->status           = ApprovalStatus::REJECT;
            $payment->save();
            DB::commit();

            return $this->responseWithSuccess(___('hub.rejected_msg'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function cancelReject($id)
    {
        try {
            $payment                   = $this->model::findOrFail($id);
            if ($payment->status != ApprovalStatus::REJECT) {
                return $this->responseWithError(___('alert.modification_not_allowed'), []);
            }
            $payment->status           = ApprovalStatus::PENDING;
            $payment->save();
            return $this->responseWithSuccess(___('hub.cancel_rejected_msg'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function processed($request)
    {
        try {
            DB::beginTransaction();
            $payment                           = $this->model::where('id', $request->id)->first();

            // Handle Debited Account Balance
            $account = Account::find($request->from_account);
            if ($payment->amount > $account->balance) {
                return $this->responseWithSuccess(__('account.not_enough_balance'),  ['status_code' => '400']);
            }
            $account->balance           = $account->balance - $payment->amount;
            $account->save();

            $transaction                = new BankTransaction();
            $transaction->account_id    = $request->from_account;
            $transaction->type          = AccountHeads::EXPENSE;
            $transaction->amount        = $payment->amount;
            $transaction->date          = date('Y-m-d H:i:s');
            $transaction->note          = ___('hub.hub_payment_withdrawal');
            $transaction->save();

            // Handle Credited Account Balance
            $account                    = Account::find($payment->hub_account_id);
            $account->balance           = $account->balance + $payment->amount;
            $account->save();

            $transaction                = new BankTransaction();
            $transaction->account_id    = $payment->hub_account_id;
            $transaction->type          = AccountHeads::INCOME;
            $transaction->amount        = $payment->amount;
            $transaction->date          = date('Y-m-d H:i:s');
            $transaction->note          = ___('hub.hub_payment_withdrawal');
            $transaction->save();

            // handle payment
            $payment->transaction_id = $request->transaction_id;
            $payment->from_account   = $request->from_account;
            $payment->status         = ApprovalStatus::PROCESSED;
            $payment->reference_file = $this->uploadRepo->uploadImage($request->reference_file, 'reference', [], $payment->reference_file);
            $payment->save();

            DB::commit();

            return $this->responseWithSuccess(___('hub_payment.processed_msg'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }

    public function cancelProcess($id)
    {
        try {
            DB::beginTransaction();

            $payment = $this->model::findOrFail($id);

            if ($payment->status != ApprovalStatus::PROCESSED) {
                return $this->responseWithError(___('alert.modification_not_allowed'));
            }

            // Handle Debited Account Balance
            $account = Account::find($payment->hub_account_id);
            if ($payment->amount > $account->balance) {
                return $this->responseWithSuccess(__('account.not_enough_balance'),  ['status_code' => '400']);
            }
            $account->balance           = $account->balance - $payment->amount;
            $account->save();

            $transaction                =  new BankTransaction();
            $transaction->account_id    =  $payment->hub_account_id;
            $transaction->type          =  AccountHeads::EXPENSE;
            $transaction->amount        =  $payment->amount;
            $transaction->date          =  date('Y-m-d H:i:s');
            $transaction->note          =  ___('hub.hub_payment_process_cancel');
            $transaction->save();

            // Handle Credited Account Balance
            $account                    = Account::find($payment->from_account);
            $account->balance           = $account->balance + $payment->amount;
            $account->save();

            $transaction                =  new BankTransaction();
            $transaction->account_id    =  $payment->from_account;
            $transaction->type          =  AccountHeads::INCOME;
            $transaction->amount        =  $payment->amount;
            $transaction->date          =  date('Y-m-d H:i:s');
            $transaction->note          =  ___('hub.hub_payment_process_cancel');
            $transaction->save();

            // manage payment
            $payment->status           = ApprovalStatus::PENDING;
            $payment->transaction_id   = null;
            $payment->from_account     = null;
            $payment->save();

            if ($payment->reference_file) {
                $this->uploadRepo->deleteImage($payment->reference_file, 'delete');
            }

            DB::commit();

            return $this->responseWithSuccess(___('hub.cancel_processed_msg'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }
}
