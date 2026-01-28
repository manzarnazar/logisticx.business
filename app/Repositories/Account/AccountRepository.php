<?php

namespace App\Repositories\Account;

use App\Models\User;
use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use App\Enums\UserType;
use App\Enums\AccountHeads;
use App\Models\Backend\Account;
use Illuminate\Support\Facades\DB;
use App\Models\Backend\BankTransaction;
use App\Models\Backend\Parcel;
use App\Repositories\Account\AccountInterface;

class AccountRepository implements AccountInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(Account $model)
    {
        $this->model = $model;
    }

    public function all($orderBy = 'id', $sortBy = 'desc')
    {
        return $this->model::with('user')->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }
    public function getAll($orderBy = 'id', $sortBy = 'desc')
    {
        return $this->model::with('user')->orderBy($orderBy, $sortBy)->get();
    }

    public function filter($request)
    {
        return $this->model::with('user')->where(function ($query) use ($request) {
            if ($request->holder_name) {
                $query->where('account_holder_name', 'like', '%' . $request->holder_name . '%');
            }
            if ($request->bank) {
                $query->where('bank', $request->bank);
            }
            if ($request->account_no) :
                $query->where('account_no', 'like', '%' . $request->account_no . '%');
            endif;
        })->orderByDesc('id')->paginate(settings('paginate_value'));
    }


    public function get($id)
    {
        return $this->model::find($id);
    }

    public function userAccount($id)
    {
        return $this->model::where('user_id', $id)->get();
    }

    public function getHubAccounts($hub_id = null)
    {
        $query = $this->model::query();

        $query->whereNotNull('hub_id');

        if ($hub_id != null) {
            $query->where('hub_id', $hub_id);
        }

        $account =  $query->get();

        return $account;
    }

    public function getAdminAccounts()
    {
        $query = $this->model::query();
        $query->with('user');
        $query->where('status', Status::ACTIVE);
        $query->whereHas('user', fn($query) => $query->where('status', Status::ACTIVE));
        $query->whereHas('user', fn($query) => $query->where('user_type', UserType::ADMIN));
        $account =  $query->get();
        return $account;
    }

    public function users()
    {
        return User::where('user_type', UserType::ADMIN)->with('upload')->get();
    }

    public function store($request)
    {
        try {

            DB::beginTransaction();
            $account                           = new $this->model;
            // $account->type                     = $request->type;
            $account->hub_id                   = $request->input('hub');
            $account->user_id                  = $request->user;
            $account->gateway                  = $request->gateway;
            if ($request->gateway == 1) :
                $account->account_holder_name  = User::find($account->user_id)->name;
                $account->opening_balance          = $request->balance;
                $account->balance                  = $request->balance;
            else :
                $account->opening_balance          = $request->opening_balance;
                $account->balance                  = $request->opening_balance;
            endif;

            if ($request->gateway == 2) {

                $account->account_holder_name  = $request->account_holder_name;
                $account->account_no           = $request->account_no;
                $account->bank_id              = $request->bank;
                $account->branch_name          = $request->branch_name;
            } elseif ($request->gateway == 3 || $request->gateway == 4 || $request->gateway == 5) {

                $account->account_holder_name  = $request->account_holder_name;
                $account->account_no           = $request->mobile;
                $account->account_type         = $request->account_type;
                $account->mobile               = $request->mobile;
            }
            $account->status                   = $request->status;
            $account->save();


            $bank_transaction                   =  new BankTransaction();
            $bank_transaction->account_id       =  $account->id;
            $bank_transaction->type             =  AccountHeads::INCOME;
            $bank_transaction->amount           =  $account->balance;
            $bank_transaction->date             =  date('Y-m-d H:i:s');
            $bank_transaction->note             =  ___('account.opening_balance');
            $bank_transaction->save();


            DB::commit();


            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($id, $request)
    {

        try {
            $account                           = $this->model::find($id);
            // because gateway change

            // $account->type                 = $request->type;
            $account->hub_id                   = $request->input('hub');
            $account->user_id              = $request->user;
            $account->gateway              = $request->gateway;
            if ($request->gateway == 1) :
                $account->account_holder_name  = User::find($account->user_id)->name;
                $account->opening_balance          = $request->balance;
                $account->balance                  = $request->balance;
            else :
                $account->opening_balance          = $request->opening_balance;
                $account->balance                  = $request->opening_balance;
            endif;

            if ($request->gateway == 1) {
                $account->account_holder_name  = null;
                $account->account_no           = null;
                $account->bank_id              = null;
                $account->branch_name          = null;

                $account->account_holder_name  = null;
                $account->account_type         = null;
                $account->mobile               = null;
            } elseif ($request->gateway == 2) {
                $account->account_holder_name  = $request->account_holder_name;
                $account->account_no           = $request->account_no;
                $account->bank_id              = $request->bank;
                $account->branch_name          = $request->branch_name;
            } else if ($request->gateway == 3 || $request->gateway == 4 || $request->gateway == 5) {

                $account->account_holder_name  = $request->account_holder_name;
                $account->account_no           = $request->mobile;
                $account->account_type         = $request->account_type;
                $account->mobile               = $request->mobile;
            }

            $account->status                   = $request->status;
            $account->save();

            $bank_transaction                   =  BankTransaction::where(['account_id' => $id, 'fund_transfer_id' => null])->first();
            if ($bank_transaction == null) :
                $bank_transaction  = new BankTransaction();
            endif;
            $bank_transaction->account_id       =  $account->id;
            $bank_transaction->type             =  AccountHeads::INCOME;
            $bank_transaction->amount           =  $account->balance;
            $bank_transaction->date             =  date('Y-m-d H:i:s');
            $bank_transaction->note             =  ___('account.opening_balance');
            $bank_transaction->save();


            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {

        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function currentBalance($data)
    {
        return $this->model::find($data['search']);
    }

    public function getAccounts($request)
    {
        $response = false;

        $query = $this->model::query();

        $query->where('status', Status::ACTIVE);

        if ($request->except_hub_id != null) {
            $query->where('hub_id', '!=', $request->except_hub_id);
        }

        if ($request->except_account_id != null) {
            $query->where('id', '!=', $request->except_account_id);
        }

        if ($request->user_id != null) {
            $query->where('user_id', $request->user_id);
            $response = true;
        }

        if ($request->hub_id != null) {
            $query->where('hub_id', $request->hub_id);
            $response = true;
        }

        if ($request->account_no != null) {
            $query->where('account_no', $request->account_no);
            $response = true;
        }

        if ($request->mobile != null) {
            $query->where('mobile', $request->mobile);
            $response = true;
        }

        if ($request->search != null && !$response) {
            $query->where('account_holder_name', 'like', "%{$request->search}%");
            $query->with('user:id,name');
            $query->orWhereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->search}%")->where('status', Status::ACTIVE);
                if ($request->except_hub_id != null) {
                    $query->where('hub_id', '!=', $request->except_hub_id);
                }
            });
            $response = true;
        }

        // if (!$response) {
        //     return [];
        // }

        $query->take(20);

        $accounts = $query->get();

        return $accounts;
    }
}
