<?php

namespace App\Models\Backend;

use App\Models\User;
use App\Enums\SalaryStatus;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Backend\Payroll\SalaryGenerate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory, LogsActivity;

    protected  $fillable = [
        'user_id',
        'month',
        'account',
        'amount',
        'date',
        'note',
    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'user.name',
            'month',
            'account',
            'amount',
            'date',
            'note',
        ];
        return LogOptions::defaults()
            ->useLogName('Salary')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function getSalary()
    {
        return $this->hasMany(SalaryGenerate::class, 'user_id', 'user_id');
    }

    public function getMyStatusAttribute()
    {
        if ($this->status == SalaryStatus::PAID) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('common.' . config('site.status.salary.' . $this->status)) . '</span>';
        } elseif ($this->status == SalaryStatus::UNPAID) {
            $status = '<span class="bullet-badge bullet-badge-danger">' . ___('common.' . config('site.status.salary.' . $this->status)) . '</span>';
        } elseif ($this->status == SalaryStatus::PARTIAL_PAID) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('common.' . config('site.status.salary.' . $this->status)) . '</span>';
        }
        return $status;
    }
}
