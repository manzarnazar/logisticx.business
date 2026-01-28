<?php

namespace App\Models\Backend;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SmsSetting extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = ['gateway', 'api_key', 'secret_key', 'username', 'user_password', 'api_url', 'status'];

    protected $table = 'sms_settings';

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
            ->useLogName('smsSettings')
            ->logOnly(['api_key', 'secret_key'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }
}
