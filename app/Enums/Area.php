<?php

namespace App\Enums;

enum Area: string
{
    case INSIDE_CITY   = 'inside_city';
    case OUTSIDE_CITY  = 'outside_city';
    case SUB_CITY      = 'sub_city';
}
