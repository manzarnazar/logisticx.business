<?php

namespace App\Models\Backend;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory,CommonHelperTrait;
    protected $fillable = ['key','value'];
}
