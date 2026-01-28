<?php

namespace App\Repositories\BankTransaction;

use App\Repositories\BankTransaction\BankTransactionInterface;
use App\Models\Backend\BankTransaction;
use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;

class BankTransactionRepository implements BankTransactionInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(BankTransaction $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::with('account')->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function filter($request, string $orderBy = 'created_at')
    {


        $query = $this->model::query();

        $query->with('account');

        if ($request->date) {
            $date = explode('to', $request->date);

            if (is_array($date)) {
                $date[1]    = $date[1] ?? $date[0];
                $from       = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                $to         = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
            }
            $query->whereBetween('date', [$from, $to]);
        }
        if ($request->account_head_id) {
            $query->where('to_head_id', $request->account_head_id);;
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->account) {
            $query->where('account_id', $request->account);;
        }

        // $query->orderByDesc('id');
        $query->latest($orderBy);
        $transactions =   $query->paginate(settings('paginate_value'));


        return $transactions;
    }
}
