<?php

namespace App\Models\Backend;

use App\Enums\AccountGateway;
use App\Models\User;
use App\Enums\Status;
use App\Models\Backend\Bank;
use App\Traits\CommonHelperTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;
    protected $fillable = ['account_holder_name', 'account_no', 'gateway'];

    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Account')
            ->logOnly(['account_holder_name', 'account_no', 'gateway'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get single row in User table.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function getAccountTypesAttribute()
    {
        $type = '';
        if ($this->account_type ==  config('site.account_types.mfs.1')) :
            $type   =  'Merchant';
        elseif ($this->account_type == config('site.account_types.mfs.2')) :
            $type   =  'Personal';
        elseif ($this->gateway == AccountGateway::Bank) :
            $type   =  'Bank';
        elseif ($this->gateway == AccountGateway::Cash) :
            $type   =  'Cash';
        endif;
        return $type;
    }

    public function getTextAttribute()
    {
        if ($this->gateway ==  AccountGateway::Cash) {
            return "Cash | {$this->user->name} | Balance: {$this->balance}";
        }

        if ($this->gateway ==  AccountGateway::Bank) {
            return "{$this->bank->bank_name} | {$this->account_holder_name} | Acc. No. {$this->account_no} | Balance: {$this->balance}";
        }

        if ($this->gateway ==  AccountGateway::Bkash) {
            return  "bKash | {$this->account_holder_name} | Acc. No. {$this->account_no} | Balance: {$this->balance}";
        }

        if ($this->gateway ==  AccountGateway::Rocket) {
            return  "Rocket | {$this->account_holder_name} | Acc. No. {$this->account_no} | Balance: {$this->balance}";
        }

        if ($this->gateway ==  AccountGateway::Nagad) {
            return  "Nagad | {$this->account_holder_name} | Acc. No. {$this->account_no} | Balance: {$this->balance}";
        }
    }
}
