<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AccountHeads;
use App\Models\Backend\Account;

class BankTransaction extends Model
{
    use HasFactory;

    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    // public function getAccountTypeAttribute()
    // {
    //     if ($this->type == AccountHeads::INCOME) {
    //         $type =  ___('AccountHeads.' . AccountHeads::INCOME);
    //     } elseif ($this->type == AccountHeads::EXPENSE) {
    //         $type = ___('AccountHeads.' . AccountHeads::EXPENSE);
    //     }
    //     return $type;
    // }

    public function getTransactionTypeAttribute()
    {
        return ___('account.' . config("site.account_head.{$this->type}"));
    }

    public function getTransactionOppositeTypeAttribute()
    {
        $type = $this->type == AccountHeads::INCOME ? AccountHeads::EXPENSE : AccountHeads::INCOME;

        return ___('account.' . config("site.account_head.{$type}"));
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function fundTransfer()
    {
        return $this->belongsTo(FundTransfer::class, 'fund_transfer_id', 'id');
    }

    public function income()
    {
        return $this->hasOne(Income::class, 'bank_transaction_id', 'id');
    }

    public function expense()
    {
        return $this->hasOne(Expense::class, 'bank_transaction_id', 'id');
    }

    public function merchantPayment()
    {
        return $this->hasOne(Payment::class, 'bank_transaction_id', 'id');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }
}
