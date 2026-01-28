<?php
return [
    'payment_method' => [
        'bank'      => 'bank',
        'mfs'       => 'mfs',
        'cash'      => 'cash',
    ],

    'mfs_providers' => [
        'bKash',
        'Nagad',
        'Rocket'
    ],

    'account_types' => [
        'bank' => [
            'Savings',
            'Current',
        ],
        'mfs' => [
            'Merchant',
            'Personal',
            'Agent',
        ]
    ],

];
