<?php

namespace Modules\HR\Entities;

use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];

    public function file()
    {
        return $this->belongsTo(Upload::class, 'file_id', 'id');
    }

    public function getDaysAttribute()
    {
        return  $this->from . ' to ' . $this->to;
    }
}
