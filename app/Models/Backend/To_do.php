<?php


namespace App\Models\Backend;

use App\Models\User;
use App\Enums\TodoStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class To_do extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = ['title', 'description', 'user_id', 'date',];

    public function getActivitylogOptions(): LogOptions
    {
        $logAttributes = ['title', 'description', 'user.name', 'date', 'status', 'note'];

        return LogOptions::defaults()->useLogName('To Do')->logOnly($logAttributes)->setDescriptionForEvent(fn(string $eventName) => "{$eventName}");
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getTodoStatusAttribute()
    {
        if ($this->status == TodoStatus::PENDING) {
            $status = '<span class="bullet-badge bullet-badge-pending">' . ___('common.' . config('site.status.todo.' . $this->status)) . '</span>';
        } elseif ($this->status == TodoStatus::PROCESSING) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('common.' . config('site.status.todo.' . $this->status)) . '</span>';
        } elseif ($this->status == TodoStatus::COMPLETED) {
            $status = '<span class="bullet-badge bullet-badge-complete">' . ___('common.' . config('site.status.todo.' . $this->status)) . '</span>';
        }

        return $status;
    }
}
