<?php

namespace App\Models;

use App\Models\Backend\Bank;
use App\Models\Backend\Merchant;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MerchantPayment extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = [

        'merchant_id',
        'payment_method',
        'bank_name',
        'holder_name',
        'account_no',
        'branch_name',
        'routing_no',
        'mobile_company',
        'mobile_no',
        'account_type',

    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'merchant.business_name',
            'payment_method',
            'bank_name',
            'holder_name',
            'account_no',
            'branch_name',
            'routing_no',
            'mobile_company',
            'mobile_no',
            'account_type',
        ];

        return LogOptions::defaults()
            ->useLogName('MerchantPayment')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

    // Merchant details
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    // Merchant details
    public function getBankNameAttribute()
    {
        $bank = Bank::find($this->bank_id);
        return $bank ? $bank->bank_name : null;
    }


    public function getTextAttribute()
    {
        if ($this->payment_method ==  'cash') {
            return   ___('account.' . $this->payment_method);
        }

        if ($this->payment_method ==  'bank') {
            return "{$this->bank->bank_name} | {$this->account_name} | {$this->account_no} | {$this->branch_name}";
        }

        if ($this->payment_method ==  'mfs') {
            return  "{$this->mfs} | {$this->mobile_no}|  {$this->account_type}";
        }
    }
}
