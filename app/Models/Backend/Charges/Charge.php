<?php

namespace App\Models\Backend\Charges;

use App\Enums\Status;
use App\Models\Backend\MerchantCharge;
use App\Models\Backend\Parcel;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory, CommonHelperTrait;

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id', 'id');
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'charge_id', 'id');
    }

    public function merchantCharge()
    {
        return $this->hasMany(MerchantCharge::class, 'charge_id', 'id');
    }
}
