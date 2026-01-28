<?php

namespace App\Models\Backend;

use App\Enums\Status;
use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PushNotification extends Model
{
    use HasFactory, LogsActivity;

    protected $table       = 'push_notifications';

    use HasFactory, LogsActivity;

    protected $fillable = ['title', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        $logAttributes = ['title', 'description'];

        return LogOptions::defaults()->useLogName('Push Notification')->logOnly($logAttributes)->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

    // Get single row in Upload table.
    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }

    public function getImageAttribute()
    {
        if (!empty($this->upload->original['original']) && file_exists(public_path($this->upload->original['original']))) {
            return asset($this->upload->original['original']);
        }
        return asset('backend/images/default/logo.png');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function getNotificationTypeAttribute()
    {
        if ($this->type == Status::ACTIVE) {
            $status = '<span class="bullet-badge bullet-badge-success">' . trans("status." . $this->type) . '</span>';
        } else {
            $status = '<span class="bullet-badge bullet-badge-danger">' . trans("status." . $this->type) . '</span>';
        }
        return $status;
    }
}
