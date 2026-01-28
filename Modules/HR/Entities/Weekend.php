<?php

namespace Modules\HR\Entities;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Weekend extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];


    public function getWeekendAttribute()
    {
        if ($this->is_weekend ==  true) {
            $weekend = '<span class="bullet-badge bullet-badge-success">' . ___('common.' . config('site.status.boolean.' . $this->is_weekend)) . '</span>';
        } else {
            $weekend = '<span class="bullet-badge bullet-badge-danger">' . ___('common.' . config('site.status.boolean.' . $this->is_weekend)) . '</span>';
        }
        return $weekend;
    }
}
