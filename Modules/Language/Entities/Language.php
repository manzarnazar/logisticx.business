<?php

namespace Modules\Language\Entities;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Language\Database\factories\LanguageFactory;

class Language extends Model
{
    use HasFactory, CommonHelperTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory()
    {
        //return LanguageFactory::new();
    }

    public function langConfig()
    {
        return $this->belongsTo(LanguageConfig::class, 'id', 'language_id');
    }
}
