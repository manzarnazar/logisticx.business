<?php

namespace App\Models\Backend;

use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Models\Backend\Setting\PickupSlot;
use App\Models\User;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DeliveryMan extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $table = 'delivery_man';

    protected $fillable = ['user_id', 'status', 'delivery_charge', 'pickup_charge', 'return_charge', 'opening_balance', 'current_balance'];

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
            ->useLogName('DeliveryMan')
            ->logOnly(['user.name', 'current_balance',])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get active row this model.
    public function scopeActive($query)
    {
        $query->where('status', Status::ACTIVE);
    }

    public function getDrivingLicenseImageAttribute()
    {
        if (!empty($this->uploadLicense->original['original']) && file_exists(public_path($this->uploadLicense->original['original']))) {
            return asset($this->uploadLicense->original['original']);
        }
        return asset('backend/images/default/user.png');
    }

    public function uploadLicense()
    {
        return $this->belongsTo(Upload::class, 'driving_license', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    public function coverage()
    {
        return $this->belongsTo(Coverage::class, 'coverage_id', 'id');
    }

    public function pickupSlot()
    {
        return $this->belongsTo(PickupSlot::class, 'pickup_slot_id', 'id');
    }

    public function parcelEvents()
    {
        return $this->hasMany(ParcelEvent::class, 'delivery_man_id', 'id');
    }

    public function pickupCommissions()
    {
        return $this->hasMany(DeliveryHeroCommission::class, 'pickup_hero_id', 'id');
    }

    public function deliveryCommissions()
    {
        return $this->hasMany(DeliveryHeroCommission::class, 'delivery_hero_id', 'id');
    }

    public function getCommissionsAttribute()
    {
        $pickupCommissions = $this->pickupCommissions;
        $deliveryCommissions = $this->deliveryCommissions;

        return $pickupCommissions->merge($deliveryCommissions);
    }

    public function getPaidCommissionAttribute()
    {
        return $this->Commissions->where('payment_status', PaymentStatus::PAID)->sum('amount');
    }

    public function getUnpaidCommissionAttribute()
    {
        return $this->Commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount');
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'delivery_man_id', 'id');
    }
}
