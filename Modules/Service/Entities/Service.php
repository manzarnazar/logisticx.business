<?php

namespace Modules\Service\Entities;

use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = ['image', 'banner_image'];

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image', 'id');
    }

    public function bannerImage()
    {
        return $this->belongsTo(Upload::class, 'banner_image', 'id');
    }
}
