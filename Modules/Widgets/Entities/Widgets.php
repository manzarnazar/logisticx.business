<?php

namespace Modules\Widgets\Entities;

use App\Enums\Status;
use App\Enums\SectionPadding;
use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Widgets\Database\factories\WidgetsFactory;

class Widgets extends Model
{
    use HasFactory, CommonHelperTrait;

    protected $fillable = [];
    protected $casts = 
                        [
                            'value'=>'array',
                            'section_padding' => 'array',
                        ];

    protected static function newFactory()
    {
        return WidgetsFactory::new();
    }


    public function getImageAttribute()
    {
        $defaultImages = [
            "original"      => asset('backend/images/avatar-1.jpg'),
            "image_one"     => asset('backend/images/avatar-2.jpg'),
            "image_two"     => asset('backend/images/avatar-3.jpg'),
            "image_three"   => asset('backend/images/avatar-3.jpg'),
        ];

        return $this->modelImageProcessor($this->upload, $defaultImages);
    }

    // Get single row in Upload table.
    public function upload()
    {
        return $this->belongsTo(Upload::class, 'bg_image', 'id');
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
