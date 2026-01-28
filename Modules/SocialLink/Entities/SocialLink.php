<?php

namespace Modules\SocialLink\Entities;

use App\Enums\Status;
use App\Models\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialLink extends Model
{
	
    use HasFactory,CommonHelperTrait;

    protected $fillable = [];

}
