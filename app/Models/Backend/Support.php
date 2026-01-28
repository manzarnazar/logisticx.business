<?php

namespace App\Models\Backend;

use App\Models\User;
use App\Enums\UserType;

use App\Models\Backend\Upload;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'department_id',
        'service',
        'priority',
        'subject',
        'description',
        'date',

    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'user.name',
            'department.title',
            'service',
            'priority',
            'subject',
            'description',
            'date',

        ];
        return LogOptions::defaults()
            ->useLogName('Support')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo(Upload::class, 'attached_file', 'id');
    }
    // Get single row in Upload table.
    public function attached_file()
    {
        return $this->belongsTo(Upload::class, 'attached_file', 'id');
    }
    public function getAttachedAttribute()
    {
        if (!empty($this->attached_file->original['original']) && file_exists(public_path($this->attached_file->original['original']))) {
            return asset($this->attached_file->original['original']);
        }
        return asset('backend/images/default/user.png');
    }

    public function supportChats()
    {
        return $this->hasMany(SupportChat::class, 'support_id', 'id');
    }

    public function getUserTypeAttribute()
    {
        $typeMappings = [
            UserType::ADMIN       => ___("common.admin"),
            UserType::MERCHANT    => ___("common.merchant"),
            UserType::DELIVERYMAN => ___("common.deliveryman"),
            UserType::INCHARGE    => ___("common.in_charge"),
            UserType::HUB         => ___("common.hub")
        ];

        return $typeMappings[$this->user->user_type] ?? null;
    }

    public function getPriorityBadgeAttribute()
    {
        $status = $this->priority;

        $statusClasses = [
            config('site.support.priority.high')    => 'danger',
            config('site.support.priority.medium')  => 'warning',
            config('site.support.priority.low')     => 'info',
        ];

        $class = $statusClasses[$status] ?? 'warning'; // Default to 'danger' if status not found

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("label.{$status}") . "</span>";
    }
}
