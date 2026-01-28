<?php

use App\Enums\AccountHeads;
use App\Enums\AccountType;
use App\Enums\ApprovalStatus;

return [

    'cod_charges' => [
        'inside_city'    => 1,
        'sub_city'       => 2,
        'outside_city'   => 3,
    ],


    'account_type' =>[
        'admin'       => AccountType::ADMIN,
        'user'        => AccountType::USER
    ],

    'account_heads_type' =>[
        'income'      => AccountHeads::INCOME,
        'expense'     => AccountHeads::EXPENSE
    ],

    'approval_status' =>[
        'Reject'      => ApprovalStatus::REJECT   ,
        'Approved'    => ApprovalStatus::APPROVED ,
        'Pending'     => ApprovalStatus::PENDING  ,
        'Processed'   => ApprovalStatus::PROCESSED,
    ],
    'api_key' => '123456rx-ecourier123456'

];
