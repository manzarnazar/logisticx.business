<?php

namespace Modules\DeliveryArea\Entities;

use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\DeliveryArea\Database\factories\DeliveryAreaFactory;

class DeliveryArea extends Model
{
    use HasFactory, CommonHelperTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }
}
