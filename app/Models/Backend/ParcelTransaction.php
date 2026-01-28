<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelTransaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'parcel_id',
        'charge',
        'cod_charge',
        'liquid_fragile_charge',
        'vas_charge',
        'discount',
        'cash_collection',
        'selling_price',
        'vat_amount',
        'total_charge',
        'current_payable',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class, 'parcel_id', 'id');
    }
}
