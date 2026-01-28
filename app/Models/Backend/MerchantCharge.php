<?php

namespace App\Models\Backend;

use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use App\Models\Backend\Charges\Charge;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\Charges\ServiceType;
use App\Models\Backend\Charges\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MerchantCharge extends Model
{
    use HasFactory, CommonHelperTrait;

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    public function generalCharge()
    {
        return $this->belongsTo(Charge::class, 'charge_id', 'id');
    }

    public function serviceType()
    {
        return $this->belongsTo(ServiceType::class, 'service_type_id', 'id');
    }
}
