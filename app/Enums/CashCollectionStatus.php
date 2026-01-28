<?php

namespace App\Enums;

enum CashCollectionStatus: string
{
    case PENDING                    = 'pending';
    case RECEIVED_BY_HUB            = 'received_by_hub';
    case RECEIVED_BY_ADMIN          = 'received_by_admin';
    case PAID_TO_MERCHANT           = 'paid_to_merchant';
}
