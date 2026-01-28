<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $attributes = [

            //language
            'language' => [
                'read'           => 'language_read',
                'create'         => 'language_create',
                'update'         => 'language_update',
                'phrase'         => 'language_phrase',
                'delete'         => 'language_delete',
            ],

            'mail_settings' => [
                'read'   => 'mail_settings_read',
                'update' => 'mail_settings_update',
            ],

            'sections' => [
                'read'              => 'section_read',
                'update'            => 'section_update',
            ],

            'service'   => [
                'read'              => 'service_read',
                'create'            => 'service_create',
                'update'            => 'service_update',
                'delete'            => 'service_delete',
                'status_update'     => 'service_status_update',
            ],

            'service_faq'   => [
                'read'              => 'service_faq_read',
                'create'            => 'service_faq_create',
                'update'            => 'service_faq_update',
                'delete'            => 'service_faq_delete',
                'status_update'     => 'service_faq_status_update',
            ],

            'home_page_slider'   => [
                'read'              => 'home_page_slider_read',
                'create'            => 'home_page_slider_create',
                'update'            => 'home_page_slider_update',
                'delete'            => 'home_page_slider_delete',
                'status_update'     => 'home_page_slider_status_update',
            ],

            'page'  => [
                'read'              => 'page_read',
                'create'            => 'page_create',
                'update'            => 'page_update',
                'delete'            => 'page_delete'
            ],

            'blog'  => [
                'read'              => 'blog_read',
                'create'            => 'blog_create',
                'update'            => 'blog_update',
                'delete'            => 'blog_delete'
            ],

            'client'    => [
                'read'              => 'client_read',
                'create'            => 'client_create',
                'update'            => 'client_update',
                'delete'            => 'client_delete'
            ],

            'features'  => [
                'read'              => 'features_read',
                'create'            => 'features_create',
                'update'            => 'features_update',
                'delete'            => 'features_delete'
            ],

            'team'  => [
                'read'              => 'team_read',
                'create'            => 'team_create',
                'update'            => 'team_update',
                'delete'            => 'team_delete'
            ],

            'testimonial'   => [
                'read'              => 'testimonial_read',
                'create'            => 'testimonial_create',
                'update'            => 'testimonial_update',
                'delete'            => 'testimonial_delete'
            ],

            'social_link' => [
                'read'              => 'social_link_read',
                'create'            => 'social_link_create',
                'update'            => 'social_link_update',
                'delete'            => 'social_link_delete',
                'status'            => 'social_link_status_update',
            ],

            'widgets'   => [
                'read'              => 'widget_read',
                'create'            => 'widget_create',
                'update'            => 'widget_update',
                'delete'            => 'widget_delete'
            ],

            'faq'   => [
                'read'              => 'faq_read',
                'create'            => 'faq_create',
                'update'            => 'faq_update',
                'delete'            => 'faq_delete'
            ],

            'gallery'   => [
                'read'              => 'gallery_read',
                'create'            => 'gallery_create',
                'update'            => 'gallery_update',
                'delete'            => 'gallery_delete'
            ],

            'delivery_area'   => [
                'read'              => 'delivery_area_read',
                'create'            => 'delivery_area_create',
                'update'            => 'delivery_area_update',
                'delete'            => 'delivery_area_delete'
            ],

            'dashboard' => [
                'read'                          => 'dashboard_read',
                'calendar'                      => 'calendar_read',
                'total_Parcel'                  => 'total_parcel',
                'total_user'                    => 'total_user',
                'total_merchant'                => 'total_merchant',
                'total_delivery_man'            => 'total_delivery_man',
                'total_hubs'                    => 'total_hubs',
                'total_accounts'                =>  'total_accounts',
                'total_parcels_pending'         =>  'total_parcels_pending',
                'total_pickup_assigned'         =>  'total_pickup_assigned',
                'total_received_warehouse'      =>  'total_received_warehouse',
                'total_deliveryman_assigned'    =>  'total_deliveryman_assigned',
                'total_partial_delivered'       =>  'total_partial_delivered',
                'total_parcels_delivered'       =>  'total_parcels_delivered',
                'recent_accounts'               =>  'recent_accounts',
                'recent_salary'                 =>  'recent_salary',
                'recent_hub'                    =>  'recent_hub',
                'all_statements'                =>  'all_statements',
                'income_expense_charts'         =>  'income_expense_charts',
                'merchant_revenue_charts'       =>  'merchant_revenue_charts',
                'deliveryman_revenue_charts'    =>  'deliveryman_revenue_charts',
                'courier_revenue_charts'        =>  'courier_revenue_charts',
                'recent_parcels'                =>  'recent_parcels',
                'bank_transaction'              =>  'bank_transaction'


            ],

            'logs'  => [
                'read'  => 'log_read'
            ],

            'hubs'  => [
                'read'                  => 'hub_read',
                'create'                => 'hub_create',
                'update'                => 'hub_update',
                'delete'                => 'hub_delete',
                'incharge_read'         => 'hub_incharge_read',
                'incharge_create'       => 'hub_incharge_create',
                'incharge_update'       => 'hub_incharge_update',
                'incharge_delete'       => 'hub_incharge_delete',
                'incharge_assigned'     => 'hub_incharge_assigned',
                'view'                  => 'hub_view',
            ],

            'accounts'  => [
                'read'                  => 'account_read',
                'read_all'              => 'account_read_all',
                'create'                => 'account_create',
                'update'                => 'account_update',
                'delete'                => 'account_delete'
            ],

            'banks' => [
                'read'                  => 'bank_read',
                'create'                => 'bank_create',
                'update'                => 'bank_update',
                'delete'                => 'bank_delete'
            ],

            'income'    => [
                'read'              => 'income_read',
                'create'            => 'income_create',
                'update'            => 'income_update',
                'delete'            => 'income_delete',
                'hub_read_all'      => 'income_hub_read_all',
            ],

            'expense'   => [
                'read'              => 'expense_read',
                'create'            => 'expense_create',
                'update'            => 'expense_update',
                'delete'            => 'expense_delete',
                'hub_read_all'      => 'expense_hub_read_all',
            ],

            'todo'  => [
                'read'              => 'todo_read',
                'create'            => 'todo_create',
                'update'            => 'todo_update',
                'delete'            => 'todo_delete'
            ],

            'fund_transfer' => [
                'read'              => 'fund_transfer_read',
                'create'            => 'fund_transfer_create',
                'update'            => 'fund_transfer_update',
                'delete'            => 'fund_transfer_delete'
            ],

            'roles' => [
                'read'              => 'role_read',
                'create'            => 'role_create',
                'update'            => 'role_update',
                'delete'            => 'role_delete'
            ],

            'designations'  => [
                'read'              => 'designation_read',
                'create'            => 'designation_create',
                'update'            => 'designation_update',
                'delete'            => 'designation_delete'
            ],

            'departments'   => [
                'read'              => 'department_read',
                'create'            => 'department_create',
                'update'            => 'department_update',
                'delete'            => 'department_delete'
            ],

            'users' => [
                'read'              => 'user_read',
                'create'            => 'user_create',
                'update'            => 'user_update',
                'delete'            => 'user_delete',
                'permission_update' => 'permission_update'
            ],

            'profile'   => [
                'read'              => 'profile_read',
                'update'            => 'profile_update',
                'email_update'      => 'email_update',
                'phone_update'      => 'phone_update',
                'password_update'   => 'password_update'
            ],

            'merchant'  => [
                'read'                      => 'merchant_read',
                'create'                    => 'merchant_create',
                'update'                    => 'merchant_update',
                'delete'                    => 'merchant_delete',
                'view'                      => 'merchant_view',

                'delivery_charge_read'      => 'merchant_delivery_charge_read',
                'delivery_charge_create'    => 'merchant_delivery_charge_create',
                'delivery_charge_update'    => 'merchant_delivery_charge_update',
                'delivery_charge_delete'    => 'merchant_delivery_charge_delete',

                'cod_charge_read'           => 'merchant_cod_charge_read',
                'cod_charge_update'         => 'merchant_cod_charge_update',

                'shop_read'                 => 'merchant_shop_read',
                'shop_create'               => 'merchant_shop_create',
                'shop_update'               => 'merchant_shop_update',
                'shop_delete'               => 'merchant_shop_delete',

                'payment_read'              => 'merchant_payment_account_read',
                'payment_create'            => 'merchant_payment_account_create',
                'payment_update'            => 'merchant_payment_account_update',
                'payment_delete'            => 'merchant_payment_account_delete',
            ],

            'payments'  => [
                'read'                      => 'payment_read',
                'create'                    => 'payment_create',
                'update'                    => 'payment_update',
                'delete'                    => 'payment_delete',
                'reject'                    => 'payment_reject',
                'process'                   => 'payment_process',
            ],

            'hub_payments'  => [
                'read'                      => 'hub_payment_read',
                'create'                    => 'hub_payment_create',
                'update'                    => 'hub_payment_update',
                'delete'                    => 'hub_payment_delete',
                'reject'                    => 'hub_payment_reject',
                'process'                   => 'hub_payment_process',
            ],

            'hub_payments_request'  => [
                'read'                  => 'hub_payment_request_read',
                'create'                => 'hub_payment_request_create',
                'update'                => 'hub_payment_request_update',
                'delete'                => 'hub_payment_request_delete',
            ],

            'liquid_fragile'    => [
                'read'                  => 'liquid_fragile_read',
                'update'                => 'liquid_fragile_update',
                'status_change'         => 'liquid_status_change',
            ],

            'database_backup'   => [
                'read'                  => 'database_backup_read',
            ],

            'sms_settings'  => [
                'read'                  => 'sms_settings_read',
                'create'                => 'sms_settings_create',
                'update'                => 'sms_settings_update',
                'delete'                => 'sms_settings_delete',
                'status_change'         => 'sms_settings_status_change',
            ],

            'sms_send_settings' => [
                'read'                  => 'sms_send_settings_read',
                'create'                => 'sms_send_settings_create',
                'update'                => 'sms_send_settings_update',
                'delete'                => 'sms_send_settings_delete',
                'status_change'         => 'sms_send_settings_status_change',
            ],

            'general_settings'  => [
                'read'                  => 'general_settings_read',
                'update'                => 'general_settings_update',
            ],

            'notification_settings' => [
                'read'                  => 'notification_settings_read',
                'update'                => 'notification_settings_update',
            ],

            'push_notification' => [
                'read'                  => 'push_notification_read',
                'create'                => 'push_notification_create',
                'update'                => 'push_notification_update',
                'delete'                => 'push_notification_delete'
            ],

            'parcel'    => [
                'read'                  => 'parcel_read',
                'parcel_details_read'   => 'parcel_details_read',
                'create'                => 'parcel_create',
                'update'                => 'parcel_update',
                'delete'                => 'parcel_delete',
                'status_update'         => 'parcel_status_update'
            ],

            'delivery_man'  => [
                'read'                  => 'delivery_man_read',
                'create'                => 'delivery_man_create',
                'update'                => 'delivery_man_update',
                'delete'                => 'delivery_man_delete'
            ],

            'delivery_category' => [
                'read'                  => 'delivery_category_read',
                'create'                => 'delivery_category_create',
                'update'                => 'delivery_category_update',
                'delete'                => 'delivery_category_delete'
            ],

            'delivery_charge'      => [
                'read'                  => 'delivery_charge_read',
                'create'                => 'delivery_charge_create',
                'update'                => 'delivery_charge_update',
                'delete'                => 'delivery_charge_delete'
            ],

            'delivery_type' => [
                'read'                  => 'delivery_type_read',
                'status_change'         => 'delivery_type_status_change',
            ],

            'category'  => [
                'read'                  => 'category_read',
                'create'                => 'category_create',
                'update'                => 'category_update',
                'delete'                => 'category_delete'
            ],

            'account_heads' => [
                'read'                  => 'account_heads_read',
                'create'                => 'account_heads_create',
                'update'                => 'account_heads_update',
                'delete'                =>  'account_heads_delete'
            ],

            'salary'    => [
                'read'                  => 'salary_read',
                'create'                => 'salary_create',
                'update'                => 'salary_update',
                'delete'                => 'salary_delete',
                'salary_generate'       => 'salary_generate',
                'salary_generate_bulk'  => 'salary_generate_bulk',
                'salary_pay'            => 'salary_pay',
                'salary_pay_reverse'    => 'salary_pay_reverse',

            ],

            'support'   => [
                'read'                  => 'support_read',
                'create'                => 'support_create',
                'update'                => 'support_update',
                'delete'                => 'support_delete',
                'reply'                 => 'support_reply'
            ],

            'bank_transaction'  => [
                'read'                          => 'bank_transaction_read',
            ],

            // 'cash_received_from_delivery_man' => [
            //     'read'  => 'cash_received_from_delivery_man_read',
            //     'create' => 'cash_received_from_delivery_man_create',
            //     'update' => 'cash_received_from_delivery_man_update',
            //     'delete' => 'cash_received_from_delivery_man_delete'
            // ],

            'reports' => [
                'parcel_status_reports' => 'parcel_status_reports',
                'parcel_wise_profit'    => 'parcel_wise_profit',
                'salary_reports'        => 'salary_reports',
                'panel_report'          => 'panel_report',
                'closing_report'        => 'closing_report',
            ],

            // 'salary_generate' => [
            //     'read'       => 'salary_generate_read',
            //     'create'     => 'salary_generate_create',
            //     'update'     => 'salary_generate_update',
            //     'delete'     => 'salary_generate_delete',
            // ],

            'fraud' => [
                'read'                  => 'fraud_read',
                'create'                => 'fraud_create',
                'update'                => 'fraud_update',
                'delete'                => 'fraud_delete',
            ],

            'subscribe' => [
                'read'                  => 'subscribe_read',
            ],

            'pickup_request' => [
                'regular'               => 'pickup_request_regular',
                'express'               => 'pickup_request_express'
            ],

            'social_login_settings' => [
                'read'                  => 'social_login_settings_read',
                'update'                => 'social_login_settings_update'
            ],

            'payout_setup_settings' => [
                'read'                  => 'payment_gateway_settings_read',
                'update'                => 'payout_setup_settings_update'
            ],

            'recaptcha_settings' => [
                'read'                  => 'recaptcha_settings_read',
                'update'                => 'recaptcha_settings_update'
            ],

            'coverage' => [
                'read'                  => 'coverage_read',
                'create'                => 'coverage_create',
                'update'                => 'coverage_update',
                'delete'                => 'coverage_delete',
            ],

            'product_category' => [
                'read'                  => 'product_category_read',
                'create'                => 'product_category_create',
                'update'                => 'product_category_update',
                'delete'                => 'product_category_delete',
            ],
            'service_type' => [
                'read'                  => 'service_type_read',
                'create'                => 'service_type_create',
                'update'                => 'service_type_update',
                'delete'                => 'service_type_delete',
            ],
            'vas' => [
                'read'                  => 'vas_read',
                'create'                => 'vas_create',
                'update'                => 'vas_update',
                'delete'                => 'vas_delete',
            ],

            'charges' => [
                'read'                  => 'charges_read',
                'create'                => 'charges_create',
                'update'                => 'charges_update',
                'delete'                => 'charges_delete',
                'cod_and_other_read'    => 'cod_and_other_read',
                'cod_and_other_update'  => 'cod_and_other_update',

            ],
            'pickup' => [
                'read'                  => 'pickup_read',
                'create'                => 'pickup_create',
                'update'                => 'pickup_update',
                'delete'                => 'pickup_delete',
            ],

            'route' => [
                'read'                  => 'route_read',
                'create'                => 'route_create',
                'update'                => 'route_update',
                'delete'                => 'route_delete',
                'search'                => 'route_search',
            ],

            'contact_us' => [
                'read'                  => 'contact_us_read',
            ],

            'coupon' => [
                'read'     => 'coupon_read',
                'create'   => 'coupon_create',
                'update'   => 'coupon_update',
                'delete'   => 'coupon_delete',
            ],
            'leave_type' => [
                'read'     => 'leave_type_read',
                'create'   => 'leave_type_create',
                'update'   => 'leave_type_update',
                'delete'   => 'leave_type_delete',
            ],
            'leave_assign' => [
                'read'     => 'leave_assign_read',
                'create'   => 'leave_assign_create',
                'update'   => 'leave_assign_update',
                'delete'   => 'leave_assign_delete',
            ],
            'leave_request' => [
                'read'     => 'leave_request_read',
                'read_all' => 'leave_request_read_all',
                'create'   => 'leave_request_create',
                'update'   => 'leave_request_update',
                'delete'   => 'leave_request_delete',
                'approve'  => 'leave_request_approve',
                'decline'  => 'leave_request_reject',
                'status'   => 'leave_request_status_update'
            ],
            'attendance' => [
                'read'     => 'attendance_read',
                'create'   => 'attendance_create',
                'update'   => 'attendance_update',
                'delete'   => 'attendance_delete',
            ],
            'weekend' => [
                'read'     => 'weekend_read',
                'create'   => 'weekend_create',
                'update'   => 'weekend_update',
                'delete'   => 'weekend_delete',
            ],
            'holiday' => [
                'read'     => 'holiday_read',
                'create'   => 'holiday_create',
                'update'   => 'holiday_update',
                'delete'   => 'holiday_delete',
            ],
            'language' => [
                'read'     => 'language_read',
                'create'   => 'language_create',
                'update'   => 'language_update',
                'delete'   => 'language_delete',
                'phrase'   => 'language_phrase',
            ],
            'app_slider' => [
                'read'     => 'app_slider_read',
                'create'   => 'app_slider_create',
                'update'   => 'app_slider_update',
                'delete'   => 'app_slider_delete',
            ],

            'customer_inquiry' => [
                'read'     => 'customer_inquiry_read',
                'create'   => 'customer_inquiry_create',
                'update'   => 'customer_inquiry_update',
                'delete'   => 'customer_inquiry_delete',
            ],

        ];


        foreach ($attributes as $key => $value) {
            $permission = new Permission();
            $permission->attribute = $key;
            $permission->keywords  = $value;
            $permission->save();
        }
    }
}
