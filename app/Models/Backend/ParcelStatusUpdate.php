<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelStatusUpdate extends Model
{
    use HasFactory;


    protected $fillable = [
        'parcel_id',
        'otp',
        'parcel_status'
    ];
}
