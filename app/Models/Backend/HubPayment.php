<?php

namespace App\Models\Backend;

use App\Enums\ApprovalStatus;
use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class HubPayment extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'hub_id',
        'amount',
        'transaction_id',
        'from_account',
        'reference_file',
        'description',

    ];

    public function getActivitylogOptions(): LogOptions
    {

        $logAttributes = [
            'hub.name',
            'amount',
            'transaction_id',
            'hubAccount.account_no',
            'fromAccount.account_no',
            'description',

        ];
        return LogOptions::defaults()
            ->useLogName('HubPayment')
            ->logOnly($logAttributes)
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }

    protected $table = 'hub_payments';

    public function scopeOrderByDesc($query, $data)
    {
        $query->orderBy($data, 'desc');
    }

    public function hub()
    {
        return $this->belongsTo(Hub::class, 'hub_id', 'id');
    }

    public function hubAccount()
    {
        return $this->belongsTo(Account::class, 'hub_account_id', 'id');
    }

    public function fromAccount()
    {
        return $this->belongsTo(Account::class, 'from_account', 'id');
    }

    public function referenceFile()
    {
        return $this->belongsTo(Upload::class, 'reference_file', 'id');
    }

    public function getStatusNameAttribute()
    {
        return $this->status ? config("site.status.approval.{$this->status}") : 'unknown';
    }

    public function getMyStatusAttribute()
    {
        $status = $this->status ? config("site.status.approval.{$this->status}") : 'unknown';

        $statusClasses = [
            ApprovalStatus::PENDING     => 'warning',
            ApprovalStatus::REJECT      => 'danger',
            ApprovalStatus::APPROVED    => 'success',
            ApprovalStatus::PROCESSED   => 'success',
        ];

        $class = $statusClasses[$this->status] ?? 'danger'; // Default to 'danger' if status not found

        return "<span class='bullet-badge  bullet-badge-{$class}'>" . ___("common.{$status}") . "</span>";
    }
}
