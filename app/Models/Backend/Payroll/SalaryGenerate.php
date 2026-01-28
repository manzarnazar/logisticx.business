<?php

namespace App\Models\Backend\Payroll;

use App\Models\User;
use App\Enums\Status;
use App\Enums\SalaryStatus;
use App\Models\Backend\Salary;

use App\Traits\CommonHelperTrait;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryGenerate extends Model
{
    use HasFactory, LogsActivity, CommonHelperTrait;

    protected $fillable = [
        'user_id',
        'month',
        'amount',
        'status',
        'due',
        'advance',
        'note'
    ];

    protected $casts = [
        'allowance' => 'json',
        'deduction' => 'json',
    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'user.name',
            'month',
            'amount',
            'due',
            'advance',
            'note',
        ];
        return LogOptions::defaults()
            ->useLogName('Salary Generate')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }


    // Get single row in User table.
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



    public function paidSalary()
    {
        return $this->hasMany(Salary::class);
    }

    public function salary()
    {
        return $this->belongsTo(Salary::class, 'user_id', 'id');
    }


    public function getTotalAllowanceAttribute()
    {
        return $this->sumAmounts($this->allowance);
    }

    public function getTotalDeductionAttribute()
    {
        return $this->sumAmounts($this->deduction);
    }

    public function getNetSalaryAttribute()
    {
        return $this->amount +  $this->totalAllowance - $this->totalDeduction;
    }


    private function sumAmounts($items)
    {
        return collect($items)->sum('amount');
    }

    //for status index blade
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
