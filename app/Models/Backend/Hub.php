<?php

namespace App\Models\Backend;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\User;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Hub extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = ['name', 'phone', 'address'];

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
            ->useLogName('Hub')
            ->logOnly(['name', 'phone', 'address'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    public function parcels()
    {
        return $this->hasMany(Parcel::class, 'hub_id', 'id');
    }

    public function coverage()
    {
        return $this->belongsTo(Coverage::class, 'coverage_id', 'id');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class, 'hub_id', 'id');
    }

    public function deliveryMans()
    {
        return $this->hasMany(User::class, 'hub_id', 'id')->where('user_type', UserType::DELIVERYMAN)->where('status', Status::ACTIVE);
    }
}
