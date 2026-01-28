<?php

namespace App\Models;

use App\Models\Backend\Coverage;
use App\Models\Backend\Hub;
use App\Models\Backend\Merchant;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MerchantShops extends Model
{

    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = [
        'merchant_id',
        'name',
        'contact_no',
        'address',
    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'merchant.business_name',
            'name',
            'contact_no',
            'address',
        ];
        return LogOptions::defaults()
            ->useLogName('MerchantShops')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Merchant details
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    public function coverage()
    {
        return $this->belongsTo(Coverage::class, 'coverage_id', 'id');
    }
}
