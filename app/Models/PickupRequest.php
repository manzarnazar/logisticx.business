<?php

namespace App\Models;

use App\Models\Backend\Merchant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function getExchangeBadgeAttribute()
    {
        $label  = $this->exchange ? ___('label.yes') : ___('label.no');
        $class  = $this->exchange ? 'success' : 'info';
        return "<span class='bullet-badge  bullet-badge-{$class}'>" . $label  . "</span>";
    }
}
