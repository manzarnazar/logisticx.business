<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeParcelPivot extends Model
{
    use HasFactory;

    protected $fillable = ['income_id'];

    public function parcel()
    {
        return $this->hasMany(Parcel::class, 'parcel_id', 'id');
    }

    public function income()
    {
        return $this->hasMany(Income::class, 'income_id', 'id');
    }
}
