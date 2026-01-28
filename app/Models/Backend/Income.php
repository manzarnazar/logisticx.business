<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Backend\Upload;
use App\Models\Backend\Account;
use App\Models\Backend\Parcel;
use App\Models\Backend\Hub;
use App\Models\User;

class Income extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'from',
        'merchant_id',
        'delivery_man_id',
        'parcel_id',
        'account_id',
        'amount',
        'date',
        'receipt',
        'note',
    ];

    /**
     * Activity Log
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Income')
            ->logOnly([

                'merchant.business_name',
                'account.account_no',
                'amount',
                'date',
                'receipt',
                'note',
            ])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get all row. Descending order using scope.
    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'receipt', 'id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function deliveryman()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id', 'id');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    public function hubAccount()
    {
        return $this->belongsTo(Account::class, 'hub_account_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function parcels()
    {
        return $this->belongsToMany(Parcel::class, 'income_parcel_pivots', 'income_id', 'parcel_id')->withTimestamps();
    }

    public function accountHead()
    {
        return $this->belongsTo(AccountHead::class, 'account_head_id', 'id');
    }

    public function bankTransaction()
    {
        return $this->belongsTo(BankTransaction::class, 'id', 'income_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userAccount()
    {
        return $this->belongsTo(Account::class, 'user_account_id', 'id');
    }
}
