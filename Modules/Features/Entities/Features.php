<?php

namespace Modules\Features\Entities;

use App\Enums\Status;
use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Features\Database\factories\FeaturesFactory;

class Features extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image', 'id');
    }
}
