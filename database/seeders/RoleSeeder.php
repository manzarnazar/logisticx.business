<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backend\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'permissions' => $this->SuperAdminPermissions(),
            ],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'permissions' => $this->adminPermissions(),
            ],
            [
                'name' => 'Hub User',
                'slug' => 'hub-user',
                'permissions' => $this->hubPermissions(),
            ],
            [
                'name' => 'Merchant',
                'slug' => 'merchant',
                'permissions' => $this->merchantPermissions(),
            ],
            [
                'name' => 'Delivery Man',
                'slug' => 'delivery-man',
                'permissions' => $this->heroPermissions(),
            ],
        ];

        foreach ($roles as $roleData) {
            $role = new Role();
            $role->name = $roleData['name'];
            $role->slug = $roleData['slug'];
            $role->permissions = $roleData['permissions'];
            $role->save();
        }
    }

    private function SuperAdminPermissions()
    {
        return [

            'income_hub_read_all',
            'expense_hub_read_all',

            'mail_settings_read',
            'mail_settings_update',

            'coupon_read',
            'coupon_create',
            'coupon_update',
            'coupon_delete',

            'profile_read',
            'profile_update',
            'email_update',
            'phone_update',
            'password_update',

            'contact_us_read',

            'section_read',
            'section_update',

            'service_read',
            'service_create',
            'service_update',
            'service_delete',
            'service_status_update',


            'service_faq_read',
            'service_faq_create',
            'service_faq_update',
            'service_faq_delete',
            'service_faq_status_update',

            'home_page_slider_read',
            'home_page_slider_create',
            'home_page_slider_update',
            'home_page_slider_delete',
            'home_page_slider_status_update',

            'page_read',
            'page_create',
            'page_update',
            'page_delete',

            'blog_read',
            'blog_create',
            'blog_update',
            'blog_delete',


            'client_read',
            'client_create',
            'client_update',
            'client_delete',

            'app_slider_read',
            'app_slider_create',
            'app_slider_update',
            'app_slider_delete',

            'features_read',
            'features_create',
            'features_update',
            'features_delete',

            'team_read',
            'team_create',
            'team_update',
            'team_delete',



            'testimonial_read',
            'testimonial_create',
            'testimonial_update',
            'testimonial_delete',

            'widget_read',
            'widget_create',
            'widget_update',
            'widget_delete',

            // Social Link
            'social_link_read',
            'social_link_create',
            'social_link_update',
            'social_link_delete',
            'social_link_status_update',

            'faq_read',
            'faq_create',
            'faq_update',
            'faq_delete',

            'gallery_read',
            'gallery_create',
            'gallery_update',
            'gallery_delete',

            'delivery_area_read',
            'delivery_area_create',
            'delivery_area_update',
            'delivery_area_delete',


            'dashboard_read',
            'calendar_read',
            'total_parcel',
            'total_user',
            'total_merchant',
            'total_delivery_man',
            'total_hubs',
            'total_accounts',
            'total_parcels_pending',
            'total_pickup_assigned',
            'total_received_warehouse',
            'total_deliveryman_assigned',
            'total_partial_delivered',
            'total_parcels_delivered',

            'recent_accounts',
            'recent_salary',
            'recent_hub',
            'all_statements',
            'income_expense_charts',
            'merchant_revenue_charts',
            'deliveryman_revenue_charts',
            'courier_revenue_charts',
            'recent_parcels',
            'bank_transaction',
            'bank_transaction_read',

            'log_read',

            'hub_read',
            'hub_create',
            'hub_update',
            'hub_delete',
            'hub_incharge_read',
            'hub_incharge_create',
            'hub_incharge_update',
            'hub_incharge_delete',
            'hub_incharge_assigned',

            'account_read',
            'account_create',
            'account_update',
            'account_delete',

            'bank_read',
            'bank_create',
            'bank_update',
            'bank_delete',

            'income_read',
            'income_create',
            'income_update',
            'income_delete',

            'expense_read',
            'expense_create',
            'expense_update',
            'expense_delete',

            'todo_read',
            'todo_create',
            'todo_update',
            'todo_delete',

            'fund_transfer_read',
            'fund_transfer_create',
            'fund_transfer_update',
            'fund_transfer_delete',

            'role_read',
            'role_create',
            'role_update',
            'role_delete',

            'designation_read',
            'designation_create',
            'designation_update',
            'designation_delete',

            'department_read',
            'department_create',
            'department_update',
            'department_delete',

            'user_read',
            'user_create',
            'user_update',
            'user_delete',
            'permission_update',

            'merchant_read',
            'merchant_create',
            'merchant_update',
            'merchant_delete',
            'merchant_view',

            'merchant_delivery_charge_read',
            'merchant_delivery_charge_create',
            'merchant_delivery_charge_update',
            'merchant_delivery_charge_delete',

            'merchant_cod_charge_read',
            'merchant_cod_charge_update',

            'merchant_shop_read',
            'merchant_shop_create',
            'merchant_shop_update',
            'merchant_shop_delete',

            'merchant_payment_account_read',
            'merchant_payment_account_create',
            'merchant_payment_account_update',
            'merchant_payment_account_delete',



            'payment_read',
            'payment_create',
            'payment_update',
            'payment_delete',
            'payment_reject',
            'payment_process',

            'hub_payment_read',
            'hub_payment_create',
            'hub_payment_update',
            'hub_payment_delete',
            'hub_payment_reject',
            'hub_payment_process',

            // 'hub_payment_request_read',
            // 'hub_payment_request_create',
            // 'hub_payment_request_update',
            // 'hub_payment_request_delete',

            'parcel_read',
            'parcel_details_read',
            'parcel_create',
            'parcel_update',
            'parcel_delete',
            'parcel_status_update',

            'delivery_man_read',
            'delivery_man_create',
            'delivery_man_update',
            'delivery_man_delete',

            'delivery_category_read',
            'delivery_category_create',
            'delivery_category_update',
            'delivery_category_delete',

            'delivery_charge_read',
            'delivery_charge_create',
            'delivery_charge_update',
            'delivery_charge_delete',

            'delivery_type_read',
            'delivery_type_status_change',

            'liquid_fragile_read',
            'liquid_fragile_update',
            'liquid_status_change',

            'category_read',
            'category_create',
            'category_update',
            'category_delete',

            'account_heads_read',
            'account_heads_update',
            'account_heads_delete',
            'account_heads_create',

            'database_backup_read',

            'salary_read',
            'salary_create',
            'salary_update',
            'salary_delete',
            'salary_generate',
            'salary_generate_bulk',
            'salary_pay',
            'salary_pay_reverse',

            'support_read',
            'support_create',
            'support_update',
            'support_delete',
            'support_reply',

            'sms_settings_read',
            'sms_settings_create',
            'sms_settings_update',
            'sms_settings_delete',

            'sms_send_settings_read',
            'sms_send_settings_create',
            'sms_send_settings_update',
            'sms_send_settings_delete',

            'general_settings_read',
            'general_settings_update',

            'notification_settings_read',
            'notification_settings_update',

            'push_notification_read',
            'push_notification_create',
            'push_notification_update',
            'push_notification_delete',

            //reports
            'parcel_status_reports',
            'parcel_wise_profit',
            'closing_report',

            'salary_reports',
            'leave_reports',
            'attendance_reports',
            'vat_reports',

            'panel_report',
            //end reports

            // 'salary_generate_read',
            // 'salary_generate_create',
            // 'salary_generate_update',
            // 'salary_generate_delete',

            'fraud_read',
            'fraud_create',
            'fraud_update',
            'fraud_delete',
            'subscribe_read',
            'pickup_request_regular',
            'pickup_request_express',


            'social_login_settings_read',
            'social_login_settings_update',
            'payment_gateway_settings_read',
            'recaptcha_settings_read',
            'recaptcha_settings_update',
            'payout_setup_settings_update',


            'payout_create',
            'hub_view',
            'paid_invoice_read',


            'coverage_read',
            'coverage_create',
            'coverage_update',
            'coverage_delete',

            'product_category_read',
            'product_category_create',
            'product_category_update',
            'product_category_delete',

            'service_type_read',
            'service_type_create',
            'service_type_update',
            'service_type_delete',

            'vas_read',
            'vas_create',
            'vas_update',
            'vas_delete',


            'cod_and_other_read',
            'cod_and_other_update',

            'charges_read',
            'charges_create',
            'charges_update',
            'charges_delete',

            'pickup_read',
            'pickup_create',
            'pickup_update',
            'pickup_delete',

            'route_read',
            'route_create',
            'route_update',
            'route_delete',
            'route_search',

            'leave_type_read',
            'leave_type_create',
            'leave_type_update',
            'leave_type_delete',

            'leave_assign_read',
            'leave_assign_create',
            'leave_assign_update',
            'leave_assign_delete',

            //superadmin can real all
            'leave_request_read',
            'leave_request_read_all',
            'leave_request_create',
            'leave_request_update',
            'leave_request_delete',
            'leave_request_status_update',
            'leave_request_approve',
            'leave_request_reject',


            'attendance_read',
            'attendance_create',
            'attendance_update',
            'attendance_delete',

            'weekend_read',
            'weekend_create',
            'weekend_update',
            'weekend_delete',

            'holiday_read',
            'holiday_create',
            'holiday_update',
            'holiday_delete',


            'language_read',
            'language_create',
            'language_update',
            'language_delete',
            'language_phrase',

            'customer_inquiry_read',
            'customer_inquiry_create',
            'customer_inquiry_update',
            'customer_inquiry_delete',
            'customer_inquiry_phrase'
        ];
    }

    private function adminPermissions()
    {
        return [
            'dashboard_read',
            'calendar_read',
            'total_parcel',
            'total_user',
            'total_merchant',
            'total_delivery_man',
            'total_hubs',
            'total_accounts',
            'total_parcels_pending',
            'total_pickup_assigned',
            'total_received_warehouse',
            'total_deliveryman_assigned',
            'total_partial_delivered',
            'total_parcels_delivered',

            'recent_accounts',
            'recent_salary',
            'recent_hub',
            'all_statements',
            'income_expense_charts',
            'merchant_revenue_charts',
            'deliveryman_revenue_charts',
            'courier_revenue_charts',
            'recent_parcels',
            'bank_transaction',


            'log_read',

            'hub_read',
            'hub_incharge_read',

            'account_read',

            'income_read',

            'expense_read',

            'todo_read',

            'sms_settings_read',

            'sms_send_settings_read',

            'general_settings_read',

            'notification_settings_read',

            'push_notification_read',
            'push_notification_create',
            'push_notification_update',
            'push_notification_delete',

            'account_heads_read',
            'account_heads_update',
            'account_heads_delete',
            'account_heads_create',

            'salary_read',
            'support_read',

            'fund_transfer_read',

            'role_read',

            'designation_read',

            'department_read',

            'user_read',

            'merchant_read',

            'merchant_delivery_charge_read',

            'merchant_cod_charge_read',

            'merchant_shop_read',

            'merchant_payment_account_read',

            'payment_read',

            'hub_payment_request_read',

            'hub_payment_read',

            'parcel_read',
            'parcel_details_read',

            'delivery_man_read',

            'delivery_category_read',

            'delivery_charge_read',

            'delivery_type_read',

            'liquid_fragile_read',

            'category_read',

            'news_offer_read',

            'sms_settings_status_change',
            'sms_send_settings_status_change',
            'bank_transaction_read',
            'database_backup_read',

            'parcel_status_reports',
            'parcel_wise_profit',
            'closing_report',

            'salary_reports',
            'leave_reports',
            'attendance_reports',
            'vat_reports',

            'panel_report',

            // 'salary_generate_read',

            'salary_read',

            'fraud_read',
            'subscribe_read',
            'pickup_request_regular',
            'pickup_request_express',

            'cash_received_from_delivery_man_read',
            'cash_received_from_delivery_man_create',
            'cash_received_from_delivery_man_update',
            'cash_received_from_delivery_man_delete',


            'social_login_settings_read',
            'social_login_settings_update',
            'payment_gateway_settings_read',


            'hub_view',
            'paid_invoice_read',


            'coverage_read',
            'coverage_create',
            'coverage_update',
            'coverage_delete',

            'product_category_read',
            'product_category_create',
            'product_category_update',
            'product_category_delete',

            'service_type_read',
            'service_type_create',
            'service_type_update',
            'service_type_delete',

            'vas_read',
            'vas_create',
            'vas_update',
            'vas_delete',

            'cod_and_other_read',
            'cod_and_other_update',

            'charges_read',
            'charges_create',
            'charges_update',
            'charges_delete',

            'pickup_read',
            'pickup_create',
            'pickup_update',
            'pickup_delete',

            'route_search',

            'leave_type_read',
            'leave_type_create',
            'leave_type_update',
            'leave_type_delete',

            'leave_assign_read',
            'leave_assign_create',
            'leave_assign_update',
            'leave_assign_delete',

            //for check: admin can real only his
            'leave_request_read',
            'leave_request_read_all',
            'leave_request_create',
            'leave_request_update',
            'leave_request_delete',

            'attendance_read',
            'attendance_create',
            'attendance_update',
            'attendance_delete',


            'language_read',
            'language_create',
            'language_update',
            'language_delete',
            'language_phrase'

        ];
    }

    private function hubPermissions()
    {
        return [
            'dashboard_read',
            'calendar_read',
            'total_parcel',
            'total_user',
            'total_merchant',
            'total_delivery_man',
            'total_hubs',
            'total_accounts',
            'total_parcels_pending',
            'total_pickup_assigned',
            'total_received_warehouse',
            'total_deliveryman_assigned',
            // 'total_partial_delivered',
            'total_parcels_delivered',

            'recent_accounts',
            'recent_salary',
            'recent_hub',
            'all_statements',
            'income_expense_charts',
            'merchant_revenue_charts',
            'deliveryman_revenue_charts',
            'courier_revenue_charts',
            'recent_parcels',
            'bank_transaction',


            'log_read',

            // 'hub_read',
            // 'hub_incharge_read',

            'account_read',

            'income_read',

            'expense_read',

            'todo_read',

            'sms_settings_read',

            'sms_send_settings_read',

            'general_settings_read',

            'notification_settings_read',

            'push_notification_read',
            'push_notification_create',
            'push_notification_update',
            'push_notification_delete',

            'account_heads_read',
            'account_heads_update',
            'account_heads_delete',
            'account_heads_create',

            // 'salary_read',
            // 'support_read',

            'fund_transfer_read',

            'role_read',

            'designation_read',

            'department_read',

            'user_read',

            // 'merchant_read',

            // 'merchant_delivery_charge_read',

            // 'merchant_cod_charge_read',

            // 'merchant_shop_read',

            // 'merchant_payment_account_read',

            // 'payment_read',

            'hub_payment_request_read',

            // 'hub_payment_read',

            'parcel_read',
            'parcel_details_read',

            'delivery_man_read',

            'delivery_category_read',

            'delivery_charge_read',

            'delivery_type_read',

            'liquid_fragile_read',

            'category_read',

            'news_offer_read',

            'sms_settings_status_change',
            'sms_send_settings_status_change',
            'bank_transaction_read',
            'database_backup_read',

            'parcel_status_reports',
            'parcel_wise_profit',
            'closing_report',

            'salary_reports',
            'leave_reports',
            'attendance_reports',
            'vat_reports',

            'panel_report',

            'salary_read',

            'fraud_read',
            'subscribe_read',
            'pickup_request_regular',
            'pickup_request_express',


            'app_slider_read',
            'app_slider_create',
            'app_slider_update',
            'app_slider_delete',

            'cash_received_from_delivery_man_read',
            'cash_received_from_delivery_man_create',
            'cash_received_from_delivery_man_update',
            'cash_received_from_delivery_man_delete',


            'social_login_settings_read',
            'social_login_settings_update',
            'payment_gateway_settings_read',


            'hub_view',
            'paid_invoice_read',


            'coverage_read',
            'coverage_create',
            'coverage_update',
            'coverage_delete',

            'product_category_read',
            'product_category_create',
            'product_category_update',
            'product_category_delete',

            'service_type_read',
            'service_type_create',
            'service_type_update',
            'service_type_delete',

            'vas_read',
            'vas_create',
            'vas_update',
            'vas_delete',

            'cod_and_other_read',
            'cod_and_other_update',

            'charges_read',
            'charges_create',
            'charges_update',
            'charges_delete',

            'pickup_read',
            'pickup_create',
            'pickup_update',
            'pickup_delete',

            'route_search',

            'leave_type_read',
            'leave_type_create',
            'leave_type_update',
            'leave_type_delete',

            'leave_assign_read',
            'leave_assign_create',
            'leave_assign_update',
            'leave_assign_delete',

            //for check: admin can real only his
            'leave_request_read',
            'leave_request_create',
            'leave_request_update',
            'leave_request_delete',

            'attendance_read',
            'attendance_create',
            'attendance_update',
            'attendance_delete',


            'hub_payment_request_read',
            'hub_payment_request_create',
            'hub_payment_request_update',
            'hub_payment_request_delete',

        ];
    }

    private function merchantPermissions()
    {
        return [

            'profile_read',
            'profile_update',
            'email_update',
            'phone_update',
            'password_update',

            'dashboard_read',

            'support_read',
            'support_create',
            'support_update',
            'support_delete',
            'support_reply',

            'parcel_read',
            'parcel_details_read',
            'parcel_create',
            'parcel_update',
            'parcel_delete',

            'coverage_read',

            'product_category_read',
            'service_type_read',

            'charges_read',
            'cod_and_other_read',
            'vas_read',

            'pickup_read',

            'merchant_payment_account_read',
            'merchant_payment_account_create',
            'merchant_payment_account_update',
            'merchant_payment_account_delete',

        ];
    }

    private function heroPermissions(): array
    {
        return  [

            'profile_read',
            'profile_update',
            'email_update',
            'phone_update',
            'password_update',

            'dashboard_read',

            'parcel_read',
            'parcel_status_update',
        ];
    }
}
