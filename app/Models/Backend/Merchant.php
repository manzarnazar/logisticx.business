<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\User;
use App\Models\Backend\Upload;
use App\Enums\Status;
use App\Models\Backend\Setting\PickupSlot;
use App\Models\MerchantPayment;
use App\Models\MerchantShops;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Stmt\Static_;

class Merchant extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = ['title', 'business_name', 'current_balance', 'user_id'];


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
            ->useLogName('Merchant')
            ->logOnly(['user.name', 'business_name', 'current_balance'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get active row this model.
    public function scopeActive($query)
    {
        $query->where('status', Status::ACTIVE);
    }

    // Get single row in User table.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function coverage()
    {
        return $this->belongsTo(Coverage::class, 'coverage_id', 'id');
    }

    // Get single row in Upload table.
    public function licensefile()
    {
        return $this->belongsTo(Upload::class, 'trade_license', 'id');
    }
    public function getTradeAttribute()
    {
        if (!empty($this->licensefile->original['original']) && file_exists(public_path($this->licensefile->original['original']))) {
            return asset($this->licensefile->original['original']);
        }
        return "https://placehold.co/50x50?text=No+File";
    }

    // Get single row in Upload table.
    public function nidfile()
    {
        return $this->belongsTo(Upload::class, 'nid_id', 'id');
    }
    public function getNidAttribute()
    {
        if (!empty($this->nidfile->original['original']) && file_exists(public_path($this->nidfile->original['original']))) {
            return asset($this->nidfile->original['original']);
        }
        return "https://placehold.co/50x50?text=No+File";
    }


    public function getMyCodChargesAttribute()
    {
        $data = '';
        foreach ($this->cod_charges as $key => $value) {
            $data .= $key . '= ' . $value . ', ';
        }
        return $data;
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'merchant_id', 'id');
    }

    public function shops()
    {
        return $this->hasMany(MerchantShops::class, 'merchant_id', 'id');
    }

    public function activeShops()
    {
        return $this->hasMany(MerchantShops::class, 'merchant_id', 'id')->where('status', Status::ACTIVE);
    }

    public function getActiveShopAttribute()
    {
        return MerchantShops::where(['merchant_id' => $this->id, 'default_shop' => Status::ACTIVE])->first();
    }

    public function pickupSlot()
    {
        return $this->belongsTo(PickupSlot::class, 'pickup_slot_id', 'id');
    }

    public function paymentAccounts()
    {
        return $this->hasMany(MerchantPayment::class, 'merchant_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'merchant_id', 'id');
    }


    public function getCodChargesAttribute(): array
    {
        return [
            'inside_city'   => merchantSetting('cod_inside_city', $this->id),
            'sub_city'      => merchantSetting('cod_sub_city', $this->id),
            'outside_city'  => merchantSetting('cod_outside_city', $this->id),
        ];
    }

    public function getLiquidFragileRateAttribute()
    {
        return merchantSetting('liquid_fragile', $this->id);
    }

    public function getVatAttribute()
    {
        return merchantSetting('merchant_vat', $this->id);
    }
}
