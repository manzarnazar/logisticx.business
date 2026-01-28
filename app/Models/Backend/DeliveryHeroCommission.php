<?php

namespace App\Models\Backend;

use App\Enums\PaymentStatus;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryHeroCommission extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [
        'expense_id',
        'payment_status',
        'status',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class, 'parcel_id', 'id');
    }

    public function getCommissionPaymentStatusAttribute()
    {
        $status = $this->payment_status ?? 'unknown';

        $statusClasses = [
            PaymentStatus::UNPAID   => 'warning',
            PaymentStatus::PAID     => 'success',
        ];

        $class = $statusClasses[$status] ?? 'warning'; // Default to 'danger' if status not found

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("label.{$status}") . "</span>";
    }


    public function pickupHero()
    {
        return $this->belongsTo(DeliveryMan::class, 'pickup_hero_id', 'id');
    }

    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id', 'id');
    }
}
