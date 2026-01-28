<?php

namespace App\Enums;

interface FixedAccountHeads
{
        // expanse 
        const PayToHub                  = 1;
        const PayDeliveryManCommission  = 2;
        const PaidToMerchant            = 3;

        // income  
        const ReceiveFromDeliveryMan    = 4;
        const ReceiveFromMerchant       = 5;
        const ReceiveFromHub            = 6;

        const PaidToAdmin               = 7;
}
