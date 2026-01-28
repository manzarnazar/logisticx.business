<?php

namespace App\Models\Backend;

use App\Enums\Status;
use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\select;

class Coverage extends Model
{
    use HasFactory, CommonHelperTrait;


    public function parent()
    {
        return $this->belongsTo(Coverage::class, 'parent_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(Coverage::class, 'parent_id', 'id')->with('child');
    }

    public function children()
    {
        return $this->hasMany(Coverage::class, 'parent_id');
    }

    public function activeChild()
    {
        return $this->hasMany(Coverage::class, 'parent_id', 'id')->where('status', Status::ACTIVE)->with('activeChild');
    }
}
