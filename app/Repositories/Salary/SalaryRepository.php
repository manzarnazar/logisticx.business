<?php

namespace App\Repositories\Salary;

use App\Enums\AccountHeads;
use App\Enums\SalaryStatus;
use App\Enums\UserType;
use App\Models\Backend\Account;
use App\Models\Backend\BankTransaction;

use App\Models\Backend\Salary;
use App\Models\User;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Traits\ReturnFormatTrait;
use App\Repositories\Salary\SalaryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalaryRepository  implements SalaryInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(SalaryGenerate $model)
    {
        $this->model = $model;
    }

    public function all(int $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderby($orderBy, $sortBy);

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function salaryFilter($request)
    {
        $salary  = $this->model::with('user')->where(function ($query) use ($request) {
            if ($request->month) {
                $query->where('month', $request->month);
            }
            if ($request->user_id) :
                $query->where('user_id', $request->user_id);
            endif;
        })->orderBy('id', 'desc')->paginate(settings('paginate_value'));
        return $salary;
    }

    public function autogenerate($request)
    {
        try {
            DB::beginTransaction();

            $users   = User::whereIn('user_type', [UserType::ADMIN, UserType::DELIVERYMAN])->get();
            foreach ($users as  $user) {
                $salaryGenerated                = $this->model::where('user_id', $user->id)->where('month', $request->month)->first();
                if (!$salaryGenerated) :
                    $salaryGenerate             = new $this->model;
                    $salaryGenerate->user_id    = $user->id;
                    $salaryGenerate->month      = $request->month;
                    $salaryGenerate->amount     = $user->salary ? $user->salary : 0;
                    $salaryGenerate->allowance  = [];
                    $salaryGenerate->deduction  = [];
                    $salaryGenerate->note       = 'Auto Generated';
                    $salaryGenerate->status     = SalaryStatus::UNPAID;
                    $salaryGenerate->save();
                endif;
            }
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_generated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function store($request)
    {
        try {
            $user  = User::find($request->user_id);

            $exists            = $this->model::where('user_id', $request->user_id)->where('month', $request->month)->exists();
            if ($exists) {
                return $this->responseWithError(___('alert.salary_already_generated'), []);
            }
            DB::beginTransaction();

            $salaryGenerate             = new $this->model;
            $salaryGenerate->user_id    = $request->user_id;
            $salaryGenerate->month      = $request->month;
            $salaryGenerate->amount     = $user->salary ?? 0;
            $salaryGenerate->allowance  = array_values($request->allowance);
            $salaryGenerate->deduction  = array_values($request->deduction);
            $salaryGenerate->note       = $request->note;
            $salaryGenerate->status     = SalaryStatus::UNPAID;
            $salaryGenerate->save();
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
            $salaryGenerate             = $this->model::find($request->id);

            if ($salaryGenerate->status != SalaryStatus::UNPAID) {
                return $this->responseWithError(___('alert.salary_already_paid'), []);
            }

            $salaryGenerate->month      = $request->month;

            $user  = User::find($salaryGenerate->user_id);
            $salaryGenerate->amount     = $user->salary ?? 0;

            $salaryGenerate->note       = $request->note;
            $salaryGenerate->allowance  = array_values($request->allowance);
            $salaryGenerate->deduction  = array_values($request->deduction);

            $salaryGenerate->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        $salaryGenerate             =  $this->model::find($id);

        if ($salaryGenerate->status != SalaryStatus::UNPAID) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }

        $salaryGenerate->delete();

        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function pay($request)
    {
        try {
            DB::beginTransaction();

            $salaryGenerate             = $this->model::find($request->salary_generate_id);

            if ($salaryGenerate->status == SalaryStatus::PAID) {
                return $this->responseWithError(___('alert.salary_already_paid'), []);
            }

            $salaryGenerate->status     = SalaryStatus::PAID;
            $salaryGenerate->save();

            $account                    = Account::find($request->account_id);

            if ($salaryGenerate->net_salary > $account->balance) {
                return $this->responseWithError(___('common.not_enough_balance'), []);
            }

            $account->balance           = ($account->balance - $salaryGenerate->net_salary);
            $account->save();

            $salary                     = new Salary();
            $salary->salary_generate_id = $salaryGenerate->id;
            $salary->user_id            = $salaryGenerate->user_id;
            $salary->account_id         = $request->account_id;
            $salary->month              = $salaryGenerate->month;
            $salary->date               = today();
            $salary->amount             = $salaryGenerate->net_salary;
            $salary->note               = $request->note;
            $salary->save();

            $transaction                = new BankTransaction();
            $transaction->account_id    = $request->account_id;
            $transaction->type          = AccountHeads::EXPENSE;
            $transaction->amount        = $salaryGenerate->net_salary;
            $transaction->date          = today();
            $transaction->note          = ___('common.user_salary_expense');
            $transaction->save();

            DB::commit();

            return $this->responseWithSuccess(___('alert.payment_successfully'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function reverseSalaryPay($request)
    {
        try {
            DB::beginTransaction();

            $salaryGenerate             = $this->model::find($request->id);

            if ($salaryGenerate->status != SalaryStatus::PAID) {
                return $this->responseWithError(___('alert.something_went_wrong'), []);
            }

            $salaryGenerate->note       = $request->note;
            $salaryGenerate->status     = SalaryStatus::UNPAID;
            $salaryGenerate->save();

            $salary                     = Salary::where('salary_generate_id', $salaryGenerate->id)->first();

            $account                    = Account::find($salary->account_id);
            $account->balance           = ($account->balance + $salary->amount);
            $account->save();

            $transaction                = new BankTransaction();
            $transaction->account_id    = $salary->account_id;
            $transaction->type          = AccountHeads::INCOME;
            $transaction->amount        = $salary->amount;
            $transaction->date          = today();
            $transaction->note          = ___('common.reverse_salary_pay');
            $transaction->save();

            $salary->delete();

            DB::commit();
            return $this->responseWithSuccess(___('common.reverse_salary_pay'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}
