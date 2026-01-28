<?php

namespace Modules\Pages\Entities;

use App\Models\User;
use App\Enums\Status;
use App\Models\Upload;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory,CommonHelperTrait;

    protected $fillable = ['key','name'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    // public function getMyStatusAttribute()
    // {
    //     if($this->status  == Status::ACTIVE):
    //         return '<span class="badge badge-pill badge-success">'.__('active').'</span>';
    //     elseif($this->status == Status::INACTIVE):
    //         return '<span class="badge badge-pill badge-danger">'.__('inactive').'</span>';
    //     endif;
    // }

}
