<?php

namespace Modules\Blog\Entities;

use App\Models\User;
use App\Enums\Status;
use App\Models\Backend\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, CommonHelperTrait;

    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class, 'banner', 'id');
    }

    public function CreatedBy()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
