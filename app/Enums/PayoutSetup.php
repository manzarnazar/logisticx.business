<?php

namespace App\Enums;

interface PayoutSetup
{
    const BKASH        = 1;
    const PAYPAL       = 2;
    const SSL_COMMERZ  = 3;
    const STRIPE       = 4;

    // const PAYONEER     = 5;
    // const VISA         = 6;
    // const SKRILL       = 7; 
    // const AAMARPAY     = 8; 
}
