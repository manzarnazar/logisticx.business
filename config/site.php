<?php

use App\Enums\Area;
use App\Enums\Status;
use App\Enums\TodoStatus;
use App\Enums\AccountHeads;
use App\Enums\ParcelStatus;
use App\Enums\SalaryStatus;
use App\Enums\BooleanStatus;
use App\Enums\SmsSendStatus;
use App\Enums\AccountGateway;
use App\Enums\ApprovalStatus;
use App\Enums\CouponType;
use App\Enums\DiscountType;
use App\Enums\PaymentStatus;
use App\Enums\SupportService;
use App\Enums\Widget;
use Modules\Leave\Enums\LeaveRequestStatus;

return [

    'slider_styles' => [
        'parallax'  => 'parallax',
        'particle'  => 'particle',
        'animation' => 'animation',
    ],

    //widgets
    'widgets' => [

        Widget::HEADER_STYLE1                   => 'header_style1',
        Widget::HEADER_STYLE2                   => 'header_style2',

        Widget::HERO_SECTION_STYLE1             => 'hero_section_style1',
        Widget::HERO_SECTION_STYLE2             => 'hero_section_style2',

        // Widget::FEATURES_STYLE1                 => 'features_style1',
        // Widget::FEATURES_STYLE2                 => 'features_style2',
        Widget::HOW_IT_WORK_STYLE1              => 'how_it_work_style1',
        Widget::HOW_IT_WORK_STYLE2              => 'how_it_work_style2',


        Widget::OUR_ACHIEVEMENT_STYLE1          => 'our_achievement_style1',
        Widget::OUR_ACHIEVEMENT_STYLE2          => 'our_achievement_style2',

        Widget::GALLERY_STYLE1                  => 'gallery_style1',

        Widget::SERVICES_STYLE1                 => 'services_style1',
        Widget::SERVICES_STYLE2                 => 'services_style2',

        Widget::DELIVERY_CALCULATOR_STYLE1      => 'delivery_calculator_style1',
        Widget::DELIVERY_CALCULATOR_STYLE2      => 'delivery_calculator_style2',

        Widget::FAQ_STYLE1                      => 'faq_style1',
        Widget::FAQ_STYLE2                      => 'faq_style2',

        Widget::CLIENT_REVIEW_STYLE1            => 'client_review_style1',
        Widget::CLIENT_REVIEW_STYLE2            => 'client_review_style2',

        Widget::BLOGS_STYLE1                    => 'blogs_style1',

        Widget::CLIENTS_STYLE1                  => 'clients_style1',
        Widget::CLIENTS_STYLE2                  => 'clients_style2',

        Widget::COVERAGE_AREA_STYLE1            => 'coverage_area_style1',
        Widget::COVERAGE_AREA_STYLE2            => 'coverage_area_style2',

        Widget::CHARGE_LIST_STYLE1              => 'charge_list_style1',

        Widget::CTA_STYLE1                      => 'cta_style1',
        Widget::CTA_STYLE2                      => 'cta_style2',

        Widget::ABOUT_US_STYLE1                 => 'about_us_style1',
        Widget::ABOUT_US_STYLE2                 => 'about_us_style2',

        Widget::FOOTER_STYLE1                   => 'footer_style1',
        Widget::FOOTER_STYLE2                   => 'footer_style2',

    ],


    'support' => [

        'services' => [
            SupportService::Pickup           => 'pickup',
            SupportService::Delivery         => 'delivery',
            SupportService::Payment          => 'payment',
            SupportService::BillingCharge    => 'billing_charge',
            SupportService::Other            => 'other',
        ],

        'priority' => [
            'high'      => 'high',
            'medium'    => 'medium',
            'low'       => 'low',
        ],
    ],


    'account_gateways' => [
        AccountGateway::Cash    => 'Cash',
        AccountGateway::Bank    => 'Bank',
        AccountGateway::Bkash   => 'bKash',
        AccountGateway::Rocket  => 'Rocket',
        AccountGateway::Nagad   => 'Nagad',
    ],

    'account_types' => [
        'bank' => [
            1 => 'Savings',
            2 => 'Current',
        ],
        'mfs' => [
            1 => 'Merchant',
            2 => 'Personal',
            // 3 => 'Agent',
        ]
    ],

    'account_head' => [
        AccountHeads::INCOME => 'income',
        AccountHeads::EXPENSE => 'expense'
    ],

    'areas' => [
        Area::INSIDE_CITY->value    => 'inside_city',
        Area::OUTSIDE_CITY->value   => 'outside_city',
        Area::SUB_CITY->value       => 'sub_city',
    ],

    'coupon_types' => [
        CouponType::COMMON->value           => 'common',
        CouponType::MERCHANT_WISE->value    => 'merchant_wise',
    ],

    'discount_types' => [
        DiscountType::FIXED->value      => 'fixed',
        DiscountType::PERCENT->value    => 'percent',
    ],

    'translations' => [

        'account'            => 'Account',
        'activityLogs'       => 'Activity Logs',
        'alert'              => 'Alert',
        'app-terms'          => 'App Terms',
        'charges'            => 'Charges',
        'common'             => 'Common',
        'dashboard'          => 'Dashboard',
        'delete'             => 'Delete',
        'frontend'           => 'Frontend',
        'hr_manage'          => 'HR Manage',
        'hub'                => 'Hub',
        'label'              => 'Label',
        'language'           => 'Language',
        'menus'              => 'Menus',
        'merchant'           => 'Merchant',
        'parcel'             => 'Parcel',
        'permissions'        => 'Permissions',
        'placeholder'        => 'Placeholder',
        'reports'            => 'Reports',
        'salary'             => 'Salary',
        'settings'           => 'Settings',


    ],

    'status' => [
        'default' => [
            Status::ACTIVE       => 'active',
            Status::INACTIVE     => 'inactive',
        ],
        'boolean' => [
            BooleanStatus::NO  => 'no',
            BooleanStatus::YES => 'yes',
        ],
        'parcel'    => [
            ParcelStatus::PENDING                            => 'pending',
            ParcelStatus::PICKUP_ASSIGN                      => 'pickup_assign',
            ParcelStatus::PICKUP_RE_SCHEDULE                 => 'pickup_re_schedule',
            ParcelStatus::RECEIVED_BY_PICKUP_MAN             => 'received_by_pickup_man',
            ParcelStatus::RECEIVED_WAREHOUSE                 => 'received_warehouse',
            ParcelStatus::TRANSFER_TO_HUB                    => 'transfer_to_hub',
            ParcelStatus::DELIVERY_MAN_ASSIGN                => 'delivery_man_assign',
            ParcelStatus::DELIVERY_RE_SCHEDULE               => 'delivery_re_schedule',
            ParcelStatus::DELIVERED                          => 'delivered',
            ParcelStatus::PICKUP_ASSIGN_CANCEL               => 'pickup_assign_cancel',
            ParcelStatus::RECEIVED_BY_PICKUP_MAN_CANCEL      => 'received_by_pickup_man_cancel',
            ParcelStatus::RECEIVED_WAREHOUSE_CANCEL          => 'received_warehouse_cancel',
            ParcelStatus::DELIVERY_MAN_ASSIGN_CANCEL         => 'delivery_man_assign_cancel',
            ParcelStatus::DELIVERY_RE_SCHEDULE_CANCEL        => 'delivery_re_schedule_cancel',
            ParcelStatus::RECEIVED_BY_HUB                    => 'received_by_hub',
            ParcelStatus::TRANSFER_TO_HUB_CANCEL             => 'transfer_to_hub_cancel',
            ParcelStatus::RECEIVED_BY_HUB_CANCEL             => 'received_by_hub_cancel',
            ParcelStatus::DELIVERED_CANCEL                   => 'delivered_cancel',
            ParcelStatus::PICKUP_RE_SCHEDULE_CANCEL          => 'pickup_re_schedule_cancel',
            ParcelStatus::RETURN_TO_COURIER                  => 'return_to_courier',
            ParcelStatus::RETURN_TO_COURIER_CANCEL           => 'return_to_courier_cancel',
            ParcelStatus::RETURN_ASSIGN_TO_MERCHANT          => 'return_assign_to_merchant',
            ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE        => 'return_merchant_re_schedule',
            ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE_CANCEL => 'return_merchant_re_schedule_cancel',
            ParcelStatus::RETURN_ASSIGN_TO_MERCHANT_CANCEL   => 'return_assign_to_merchant_cancel',
            ParcelStatus::RETURN_RECEIVED_BY_MERCHANT        => 'return_received_by_merchant',
            ParcelStatus::RETURN_RECEIVED_BY_MERCHANT_CANCEL => 'return_received_by_merchant_cancel',
            ParcelStatus::PARTIAL_DELIVERED                  => 'partial_delivered',
            ParcelStatus::PARTIAL_DELIVERED_CANCEL           => 'partial_delivered_cancel',
        ],
        'sms_send' => [
            SmsSendStatus::PARCEL_CREATE                => "parcel_create",
            SmsSendStatus::DELIVERED_CANCEL_CUSTOMER    => "delivered_cancel_customer",
            SmsSendStatus::DELIVERED_CANCEL_MERCHANT    => "delivered_cancel_merchant"
        ],
        'hr_leave' => [
            LeaveRequestStatus::PENDING => 'pending',
            LeaveRequestStatus::APPROVED => 'approved',
            LeaveRequestStatus::REJECTED => 'rejected'
        ],
        'salary' => [
            SalaryStatus::PAID         => 'paid',
            SalaryStatus::UNPAID       => 'unpaid',
            SalaryStatus::PARTIAL_PAID => 'partial_paid',
        ],
        'todo' => [
            TodoStatus::PENDING => 'pending',
            TodoStatus::PROCESSING => 'processing',
            TodoStatus::COMPLETED => 'completed'
        ],
        'payment_status' => [
            PaymentStatus::PAID => 'paid',
            PaymentStatus::UNPAID => 'unpaid',
        ],
        'approval' => [
            ApprovalStatus::PENDING     => 'pending',
            ApprovalStatus::REJECT      => 'reject',
            ApprovalStatus::APPROVED    => 'approved',
            ApprovalStatus::PROCESSED   => 'processed',
        ],

    ],

    'date_format' => [
        'M j, Y',
        'F d, Y',
        'j F Y',
        'm.d.y',
        'd-m-Y',
        'd/m/Y',
        'D M j Y',
        'jS F, Y (l)',
        'l, jS F Y',
    ],

    'time_format' => [
        'g:i a',
        'h:i:s A',
        'H:i:s',
    ],
];
