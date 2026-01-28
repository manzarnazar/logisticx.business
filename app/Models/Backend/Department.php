<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Enums\Status;
use App\Traits\CommonHelperTrait;

class Department extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = ['title'];

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
            ->useLogName('Department')
            ->logOnly(['title'])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    // Get active row this model.
    public function scopeActive($query)
    {
        $query->where('status', Status::ACTIVE);
    }
}
