<?php

namespace Modules\Client\Entities;

use App\Enums\Status;
use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = ['name', 'logo', 'position', 'title', 'facebook_id', 'twitter_id', 'twitter_id'];


    public function upload()
    {
        return $this->belongsTo(Upload::class, 'logo', 'id');
    }

    public function getClientLogoAttribute()
    {
        $defaultImages = [
            "original"    => asset('backend/images/avatar-1.jpg'),
            "image_one"   => asset('backend/images/avatar-2.jpg'),
            "image_two"   => asset('backend/images/avatar-3.jpg'),
            "image_three" => asset('backend/images/avatar-3.jpg'),
        ];
        return $this->modelImageProcessor($this->upload, $defaultImages);
    }

    // public function getMyStatusAttribute()
    // {
    //     if ($this->status == Status::ACTIVE) {
    //         return '<span class="badge badge-pill badge-success">' . ___('active') . '</span>';
    //     } elseif ($this->status == Status::INACTIVE) {
    //         return '<span class="badge badge-pill badge-danger">' . ___('inactive') . '</span>';
    //     }
    // }
}
