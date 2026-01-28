<?php

namespace App\Models;

use App\Models\Backend\Parcel;
use App\Models\Backend\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MerchantPaymentPivot extends Model
{
    use HasFactory;


    public function parcel()
    {
        return $this->belongsTo(Parcel::class, 'parcel_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id', 'id');
    }
}
