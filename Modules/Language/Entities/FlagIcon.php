<?php

namespace Modules\Language\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Language\Database\factories\FlagIconFactory;

class FlagIcon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): FlagIconFactory
    {
        //return FlagIconFactory::new();
    }
}
