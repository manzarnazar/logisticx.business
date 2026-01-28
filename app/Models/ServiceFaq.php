<?php

namespace App\Models;

use App\Traits\CommonHelperTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFaq extends Model
{
    use HasFactory,CommonHelperTrait;
    // table name define 
    protected $table = 'service_faqs';
}
