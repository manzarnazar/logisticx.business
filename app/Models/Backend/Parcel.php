<?php

namespace App\Models\Backend;

// use DNS1D;
// use DNS2D;

// use Milon\Barcode\DNS1D;
// use Milon\Barcode\DNS2D;
use App\Enums\ParcelStatus;
use App\Models\MerchantShops;
use App\Models\Backend\Income;
use App\Traits\CommonHelperTrait;
use Spatie\Activitylog\LogOptions;
use App\Enums\CashCollectionStatus;
use App\Models\MerchantPaymentPivot;
use App\Models\Backend\Charges\Charge;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Charges\ServiceType;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Backend\DeliveryHeroCommission;
use App\Models\Backend\Charges\ProductCategory;
use App\Models\Backend\Charges\ValueAddedService;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parcel extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $table = 'parcels';

    protected $casts = ['vas' => 'array', 
        'quantity' => 'integer',
        'product_category_id' => 'integer',
        'service_type_id' => 'integer',
        'merchant_id' => 'integer',
        'merchant_shop_id' => 'integer',
        'status' => 'integer',
        'destination' => 'integer',
        'is_parcel_bank' => 'boolean',
        'charge' => 'float',
        'cash_collection' => 'float',
        'selling_price' => 'float',
        'payable' => 'float',
    ];


    protected $fillable = [
        'merchant_id',
        'vat',
        'first_hub_id',
        'hub_id',
        'area',
        'merchant_shop_id',
        'pickup_phone',
        'pickup_address',
        'pickup',
        'destination',
        'invoice_no',
        'customer_name',
        'customer_phone',
        'customer_address',
        'note',
        'product_category_id',
        'service_type_id',
        'quantity',
        'charge_id',
        'vas',
        'coupon',
        'tracking_id',
        'cash_collection_status',
        'is_charge_paid',
    ];

    public function parcelTransaction()
    {
        return $this->hasOne(ParcelTransaction::class, 'parcel_id', 'id');
    }


    public function parcelEvent()
    {
        return $this->hasMany(ParcelEvent::class, 'parcel_id', 'id');
    }

    public function getTotalVasPriceAttribute()
    {
        $totalVasPrice  = 0;
        if ($this->vas) :
            foreach ($this->vas as $key => $item) {
                $totalVasPrice  += $item['price'];
            }
        endif;
        return $totalVasPrice;
    }

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
            ->useLogName('Parcel')
            ->logOnly(['merchant.business_name', 'pickup_address', 'pickup_phone', 'customer_name', 'customer_phone', 'customer_address', 'invoice_no',])
            ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

    // Merchant details
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id')->with('user', 'shops');
    }

    public function shop()
    {
        return $this->belongsTo(MerchantShops::class, 'merchant_shop_id', 'id');
    }

    public function getMyItemTypeAttribute()
    {
        $itemType = '';
        foreach (trans("parcelType") as $key => $value) {
            if ($this->item_type == $key) {
                $itemType = $value;
            }
        }
        return $itemType;
    }

    public function getMyDeliveryTypeAttribute()
    {
        $deliveryType = '';
        foreach (trans("DeliveryType") as $key => $value) {
            if ($this->delivery_type == $key) {
                $deliveryType = $value;
            }
        }
        return $deliveryType;
    }


    public function getCashCollectStatusAttribute()
    {
        $status = $this->cash_collection_status ?? 'unknown';

        $statusClasses = [
            CashCollectionStatus::PENDING->value                   => 'warning',
            CashCollectionStatus::RECEIVED_BY_HUB->value           => 'info',
            CashCollectionStatus::RECEIVED_BY_ADMIN->value         => 'success',
        ];

        $class = $statusClasses[$status] ?? 'warning'; // Default to 'danger' if status not found

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("label.{$status}") . "</span>";
    }

    public function getParcelStatusAttribute()
    {
        $statusClasses = [
            ParcelStatus::PICKUP_ASSIGN                 => 'info',
            ParcelStatus::RECEIVED_WAREHOUSE            => 'info',
            ParcelStatus::DELIVERY_RE_SCHEDULE          => 'info',
            ParcelStatus::RETURN_TO_COURIER             => 'info',
            ParcelStatus::TRANSFER_TO_HUB               => 'info',
            ParcelStatus::RECEIVED_BY_HUB               => 'info',
            ParcelStatus::RETURN_ASSIGN_TO_MERCHANT     => 'info',
            ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE   => 'info',
            ParcelStatus::PICKUP_RE_SCHEDULE            => 'info',
            ParcelStatus::RETURN_RECEIVED_BY_MERCHANT   => 'success',
            ParcelStatus::DELIVERED                     => 'success',
            ParcelStatus::PARTIAL_DELIVERED             => 'success',
            ParcelStatus::RECEIVED_BY_PICKUP_MAN        => 'success',
            ParcelStatus::DELIVERY_MAN_ASSIGN           => 'warning',
            ParcelStatus::PENDING                       => 'warning',
        ];

        $class = $statusClasses[$this->status] ?? 'secondary'; // Default to 'secondary' if status not found

        $status = '<span class="bullet-badge  bullet-badge-' . $class . '">' . ___('parcel.' . config('site.status.parcel.' . $this->status)) . '</span>';

        if ($this->status == ParcelStatus::TRANSFER_TO_HUB) {
            $status .= '<br><span class="mt-1">' . $this->hub->name . ' To ' . $this->transferhub->name . '</span>';
        }

        return $status;
    }

    public function getStatusParcelAttribute($status_id)
    {
        if ($status_id == ParcelStatus::PENDING) {
            $status = '<span class="bullet-badge bullet-badge-danger">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::PICKUP_ASSIGN) {
            $status = '<span class="bullet-badge bullet-badge-primary">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_WAREHOUSE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERY_MAN_ASSIGN) {
            $status = '<span class="bullet-badge bullet-badge-warning">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERY_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_TO_COURIER) {
            $status = '<span class="bullet-badge bullet-badge-info">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT) {
            $status = '<span class="bullet-badge bullet-badge-dark">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-dark">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_RECEIVED_BY_MERCHANT) {
            $status = '<span class="bullet-badge bullet-badge-success">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERED) {
            $status = '<span class="bullet-badge bullet-badge-success">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::PARTIAL_DELIVERED) {
            $status = '<span class="bullet-badge bullet-badge-success">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::PICKUP_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-dark">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_BY_PICKUP_MAN) {
            $status = '<span class="bullet-badge bullet-badge-success">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::TRANSFER_TO_HUB) {
            $status = '<span class="bullet-badge bullet-badge-info">' . trans("parcelStatus." . $status_id) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_BY_HUB) {
            $status = '<span class="bullet-badge bullet-badge-info">' . trans("parcelStatus." . $status_id) . '</span>';
        }
        return $status;
    }

    public function incomes()
    {
        return $this->belongsToMany(Income::class, 'income_parcel_pivot')->withTimestamps();
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }
    public function transferhub()
    {
        return $this->belongsTo(Hub::class, 'transfer_hub_id', 'id');
    }

    public function getStatusNameAttribute()
    {
        return ___('parcel.' . config('site.status.parcel.' . $this->status));
    }

    public function getAreaNameAttribute()
    {
        return ___('charges.' . config('site.areas.' . $this->area));
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class, 'charge_id', 'id');
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id', 'id');
    }

    public function pickupArea()
    {
        return $this->belongsTo(Coverage::class, 'pickup', 'id');
    }

    public function destinationArea()
    {
        return $this->belongsTo(Coverage::class, 'destination', 'id');
    }

    public function merchantPaymentPivot()
    {
        return $this->hasOne(MerchantPaymentPivot::class, 'parcel_id', 'id');
    }

    public function deliveryHeroCommission()
    {
        return $this->hasMany(DeliveryHeroCommission::class, 'parcel_id', 'id');
    }


    public function getVasNamesAttribute()
    {
        $vasIds = collect($this->vas)->pluck('id');
        return ValueAddedService::whereIn('id', $vasIds)->pluck('name');
    }
}
