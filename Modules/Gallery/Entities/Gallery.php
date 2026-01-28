<?php

namespace Modules\Gallery\Entities;

use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Gallery\Database\factories\GalleryFactory;

class Gallery extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = ['title', 'position', 'status', 'image', 'description'];

    /**
     * The attributes that are mass assignable.
     */

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'image_id', 'id');
    }
}
