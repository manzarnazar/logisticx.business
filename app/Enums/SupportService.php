<?php

namespace App\Enums;

interface SupportService
{
    const Pickup            = 'pickup';
    const Delivery          = 'delivery';
    const Payment           = 'payment';
    const BillingCharge     = 'billing_charge';
    const Other             = 'other';
}
