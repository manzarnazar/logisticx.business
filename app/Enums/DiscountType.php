<?php

namespace App\Enums;


enum DiscountType: int
{
    case FIXED    = 1;
    case PERCENT  = 2;
}
