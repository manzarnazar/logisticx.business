<?php

namespace Modules\Language\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Language\Database\factories\LanguageConfigFactory;

class LanguageConfig extends Model
{
    use HasFactory, LogsActivity;
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('LanguageConfig')
            ->logOnly(['language.name', 'name', 'script', 'native', 'regional',])
            ->setDescriptionForEvent(fn (string $eventName) => "{$eventName}");
    }
}
