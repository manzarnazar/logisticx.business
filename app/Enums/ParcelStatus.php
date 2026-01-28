<?php

namespace App\Enums;

interface ParcelStatus
{
    const PENDING                            = 1;

    const PICKUP_ASSIGN                      = 2;
    const PICKUP_ASSIGN_CANCEL               = 3;

    const PICKUP_RE_SCHEDULE                 = 4;
    const PICKUP_RE_SCHEDULE_CANCEL          = 5;

    const RECEIVED_BY_PICKUP_MAN             = 6;
    const RECEIVED_BY_PICKUP_MAN_CANCEL      = 7;

    const RECEIVED_WAREHOUSE                 = 8;
    const RECEIVED_WAREHOUSE_CANCEL          = 9;

    const TRANSFER_TO_HUB                    = 10;
    const TRANSFER_TO_HUB_CANCEL             = 11;

    const RECEIVED_BY_HUB                    = 12;
    const RECEIVED_BY_HUB_CANCEL             = 13;

    const DELIVERY_MAN_ASSIGN                = 14;
    const DELIVERY_MAN_ASSIGN_CANCEL         = 15;

    const DELIVERY_RE_SCHEDULE               = 16;
    const DELIVERY_RE_SCHEDULE_CANCEL        = 17;

    const DELIVERED                          = 18;
    const DELIVERED_CANCEL                   = 19;

    const PARTIAL_DELIVERED                  = 20;
    const PARTIAL_DELIVERED_CANCEL           = 21;

    const RETURN_TO_COURIER                  = 22;
    const RETURN_TO_COURIER_CANCEL           = 23;

    const RETURN_ASSIGN_TO_MERCHANT          = 24;
    const RETURN_ASSIGN_TO_MERCHANT_CANCEL   = 25;

    const RETURN_MERCHANT_RE_SCHEDULE        = 26;
    const RETURN_MERCHANT_RE_SCHEDULE_CANCEL = 27;

    const RETURN_RECEIVED_BY_MERCHANT        = 28;
    const RETURN_RECEIVED_BY_MERCHANT_CANCEL = 29;
}
