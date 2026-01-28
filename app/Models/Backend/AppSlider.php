<?php

namespace App\Models\Backend;

use App\Traits\CommonHelperTrait;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppSlider extends Model
{
    use HasFactory, CommonHelperTrait;

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }
}
