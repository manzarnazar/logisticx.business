<?php

namespace App\Models\Backend;

use App\Enums\ApprovalStatus;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Models\MerchantPayment;
use App\Models\MerchantPaymentPivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Payment extends Model
{
    use HasFactory, LogsActivity;


    protected $fillable = [
        'merchant_id',
        'amount',
        'merchant_account',
        'transaction_id',
        'from_account',
        'description',

    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'merchant.business_name',
            'amount',
            'merchantAccount.holder_name',
            'transaction_id',
            'frompayment.account_no',
            'description',

        ];
        return LogOptions::defaults()
            ->useLogName('Merchant Payment')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }



    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function merchantAccount()
    {
        return $this->belongsTo(MerchantPayment::class, 'merchant_account', 'id');
    }
    public function frompayment()
    {
        return $this->belongsTo(Account::class, 'from_account', 'id');
    }
    public function referencefile()
    {
        return $this->belongsTo(Upload::class, 'reference_file', 'id');
    }

    public function parcelPivot()
    {
        return $this->hasMany(MerchantPaymentPivot::class, 'payment_id', 'id');
    }


    public function getMyStatusAttribute()
    {
        $status = $this->status ?? 'unknown';

        $statusClasses = [
            ApprovalStatus::PENDING     => 'warning',
            ApprovalStatus::REJECT      => 'danger',
            ApprovalStatus::APPROVED    => 'success',
            ApprovalStatus::PROCESSED   => 'success',
        ];

        $class = $statusClasses[$status] ?? 'warning'; // Default to 'danger' if status not found

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("approvalstatus.{$status}") . "</span>";
    }
}
