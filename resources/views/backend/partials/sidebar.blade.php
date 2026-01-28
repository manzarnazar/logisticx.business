<!--********************************** Sidebar start ***********************************-->
<ul >

    @if (hasPermission('dashboard_read'))
    <li> <a class="" href="{{ route('dashboard.index') }}" aria-expanded="true"> <i class="icon-chart"></i><span class="nav-text">{{ ___('menus.dashboard') }}</span> </a> </li>
    @endif


    @if (hasPermission('parcel_read'))

    <li class="has-submenu " >
        <a class="has-arrow" href="javascript:void()" ><i class="icon-bag"></i><span class="nav-text">{{ ___('menus.parcel_manage') }}</span></a>
        <ul class="submenu">

            <li> <a href="{{ route('parcel.index') }}"  >{{ ___('menus.all_parcel') }}</a> </li>


            <li> <a href="{{ route('parcel.index', ['slug' => 'pending']) }}"  >{{ ___('parcel.pending') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'pickup-assign']) }}"  >{{ ___('parcel.pickup_assign') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'received-by-pickup-man']) }}"  >{{ ___('parcel.received_by_pickup_man') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'received-warehouse']) }}"  >{{ ___('parcel.received_warehouse') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'delivery-man-assign']) }} "  >{{ ___('parcel.deliveryman_assign') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'delivered']) }}"  >{{ ___('parcel.delivered') }}</a> </li>

            <li> <a href="{{ route('parcel.index', ['slug' => 'partial-delivered']) }}"  >{{ ___('parcel.partial_delivered') }}</a> </li>

        </ul>
    </li>
    @endif

    @if (hasPermission('pickup_request_regular') || hasPermission('pickup_request_express'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()"><i class=" icon-rocket"></i><span class="nav-text">{{ ___('menus.pickup_request') }}</span></a>
        <ul class="submenu" >

            @if (hasPermission('pickup_request_regular'))
            <li> <a href="{{ route('pickup.request.regular') }}" >{{ ___('menus.regular') }}</a> </li>
            @endif

            @if (hasPermission('pickup_request_express'))
            <li> <a href="{{ route('pickup.request.express') }}" >{{ ___('menus.express') }}</a> </li>
            @endif

        </ul>
    </li>
    @endif

    @if (hasPermission('coverage_read'))
    <li > <a class=""  href="{{ route('coverage.index') }}"><i class=" icon-location-pin"></i><span class="nav-text">{{ ___('menus.coverage') }}</span></a> </li>
    @endif

    {{-- Charges --}}
    @if (hasPermission('product_category_read') ||
    hasPermission('service_type_read') ||
    hasPermission('vas_read') ||
    hasPermission('cod_and_other_read') ||
    hasPermission('charges_read'))
    <li class="has-submenu {{ request()->is('admin/charges/charge/create') ? 'open' : '' }} ">
        <a class="has-arrow" href="javascript:void()" ><i class=" icon-drawar"></i><span class="nav-text">{{ ___('charges.charges') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('product_category_read'))
            <li><a href="{{ route('productCategory') }}">{{ ___('charges.product_category') }}</a> </li>
            @endif

            @if (hasPermission('service_type_read'))
            <li><a href="{{ route('serviceType') }}" >{{ ___('charges.service_type') }}</a> </li>
            @endif

            @if (hasPermission('vas_read'))
            <li><a href="{{ route('vas') }}" >{{ ___('charges.vas') }}</a> </li>
            @endif

            @if (hasPermission('cod_and_other_read'))
            <li><a href="{{ route('cod-and-others') }}">{{ ___('charges.cod') }}</a> </li>
            @endif

            @if (hasPermission('charges_read'))
            <li ><a href="{{ route('charge.index') }}">{{ ___('charges.charges') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif
    {{-- End charges --}}


    @if (hasPermission('account_read') || hasPermission('fund_transfer_read') || auth()->user()->hub_id)
    <li class="has-submenu">

        <a class="has-arrow" href="javascript:void()" ><i class="icon-wallet"></i><span class="nav-text">{{ ___('menus.accounts') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('account_heads_read'))
            <li> <a href="{{ route('account.heads.index') }}">{{ ___('menus.account_heads') }}</a> </li>
            @endif

            @if (hasPermission('account_read'))
            <li> <a href="{{ route('accounts.index') }}">{{ ___('menus.accounts') }}</a> </li>
            @endif

            @if (hasPermission('bank_read'))
            <li> <a href="{{ route('banks.index') }}">{{ ___('menus.banks') }}</a> </li>
            @endif

            @if (hasPermission('fund_transfer_read'))
            <li> <a href="{{ route('fund-transfer.index') }}">{{ ___('menus.fund_transfer') }}</a> </li>
            @endif

            @if (hasPermission('income_read'))
            <li> <a href="{{ route('income.index') }}" >{{ ___('menus.income') }}</a> </li>
            @endif

            @if (hasPermission('expense_read'))
            <li> <a href="{{ route('expense.index') }}" >{{ ___('menus.expense') }}</a> </li>
            @endif

            @if (hasPermission('bank_transaction_read'))
            <li> <a href="{{ route('bank-transaction.index') }}" >{{ ___('menus.bank_transaction') }}</a> </li>
            @endif

            @if (hasPermission('hub_payment_request_read'))
            <li> <a href="{{ route('hub-panel.payment-request.index') }}">{{ ___('menus.hub_payment_request') }}</a> </li>
            @endif

        </ul>
    </li>
    @endif

    @if (hasPermission('merchant_read') || hasPermission('payment_read'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()" ><i class=" icon-shield"></i><span class="nav-text">{{ ___('menus.merchant_manage') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('merchant_read'))
            <li> <a href="{{ route('merchant.index') }}" >{{ ___('menus.merchants') }}</a> </li>
            @endif
            @if (hasPermission('payment_read'))
            <li> <a href="{{ route('merchant.manage.payment.index') }}" >{{ ___('menus.payments') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif

    @if (hasPermission('delivery_man_read'))
    <li >
        <a href="{{ route('deliveryman.index') }}" > <i class="icon-people"></i><span class="nav-text">{{ ___('menus.deliveryman') }}</span> </a>
    </li>
    @endif

    @if (hasPermission('hub_read') || hasPermission('hub_payment_read'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()" ><i class="icon-home"></i><span class="nav-text">{{ ___('menus.hub_mange') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('hub_read'))
            <li> <a href="{{ route('hubs.index') }}" >{{ ___('menus.hubs') }}</a> </li>
            @endif

            @if (hasPermission('hub_payment_read'))
            <li> <a href="{{ route('hub.hub-payment.index') }}">{{ ___('menus.payments') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif

    @if (hasPermission('coupon_read'))
    <li >
        <a href="{{ route('coupon.index') }}"> <i class="icon-credit-card"></i><span class="nav-text">{{ ___('menus.coupon') }}</span> </a>
    </li>
    @endif






    @if (hasPermission('role_read') || hasPermission('designation_read') || hasPermission('department_read') || hasPermission('user_read'))

    <li class="has-submenu ">

        <a class="has-arrow" href="javascript:void()" ><i class=" icon-people"></i><span class="nav-text">{{ ___('menus.user_role') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('role_read'))
            <li> <a href="{{ route('roles') }}" >{{ ___('menus.roles') }}</a> </li>
            @endif

            @if (hasPermission('designation_read'))
            <li> <a href="{{ route('designations') }}" >{{ ___('menus.designations') }}</a> </li>
            @endif

            @if (hasPermission('department_read'))
            <li> <a href="{{ route('departments') }}" >{{ ___('menus.departments') }}</a> </li>
            @endif

            @if (hasPermission('user_read'))
            <li> <a href="{{ route('users') }}" >{{ ___('menus.users') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif

    @if (hasPermission('weekend_read') || hasPermission('holiday_read'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()" ><i class="icon-user"></i><span class="nav-text">{{ ___('menus.hr_manage') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('weekend_read'))
            <li> <a href="{{ route('weekend.index') }}" >{{ ___('menus.weekend') }}</a> </li>
            @endif

            @if (hasPermission('holiday_read'))
            <li> <a href="{{ route('holiday.index') }}" >{{ ___('menus.holiday') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif

    @if (hasPermission('leave_type_read') || hasPermission('leave_assign_read') || hasPermission('leave_request_read'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()" ><i class="icon-home"></i><span class="nav-text">{{ ___('menus.leaves_manage') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('leave_type_read'))
            <li> <a href="{{ route('leave.type.index') }}" >{{ ___('menus.leave_type') }}</a> </li>
            @endif

            @if (hasPermission('leave_assign_read'))
            <li> <a href="{{ route('leave.assign.index') }}" >{{ ___('menus.leave_assign') }}</a> </li>
            @endif

            @if (hasPermission('leave_request_read') && haspermission('leave_request_read_all'))
            <li> <a href="{{ route('all-leave-request.index') }}" >{{ ___('menus.all_leave_request') }}</a> </li>
            @endif

            @if (hasPermission('leave_request_read'))
            <li> <a href="{{ route('leave.request.self.index') }}" class="{{ request()->is('admin/leave/my-leave-request/*') ? 'active' : '' }}">{{ ___('menus.my_leave_request') }}</a> </li>

            @endif

        </ul>
    </li>
    @endif

    @if (hasPermission('attendance_read'))
    <li class="has-submenu">
        <a class="has-arrow" href="javascript:void()" ><i class=" icon-rocket"></i><span class="nav-text">{{ ___('menus.attendances') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('attendance_read'))
            <li> <a href="{{ route('attendance.index') }}">{{ ___('menus.attendance') }}</a> </li>
            @endif
        </ul>
    </li>
    @endif

    @if (hasPermission('salary_read') || hasPermission('paid_salary_read'))
    <li class="has-submenu ">
        <a class="has-arrow" href="javascript:void()" ><i class=" icon-wallet"></i><span class="nav-text">{{ ___('common.payroll') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('salary_read'))
            <li> <a href="{{ route('salary.index') }}">{{ ___('menus.salary') }}</a> </li>
            @endif

        </ul>
    </li>
    @endif

    @if (hasPermission('parcel_status_reports') ||
    hasPermission('parcel_wise_profit') ||
    hasPermission('panel_report') ||
    hasPermission('closing_report') ||
    hasPermission('leave_reports') ||
    hasPermission('attendance_reports') ||
    hasPermission('salary_reports') ||
    hasPermission('vat_reports'))

    <li class="has-submenu">
        <a class="has-arrow" href="javascript:void()" ><i class="icon-docs"></i><span class="nav-text">{{ ___('reports.title') }}</span></a>
        <ul class="submenu">
            @if (hasPermission('parcel_status_reports'))
            <li> <a href="{{ route('parcel.reports') }}" >{{ ___('reports.parcel_reports') }}</a>
            </li>
            @endif

            @if (hasPermission('parcel_wise_profit'))
            <li> <a href="{{ route('parcel.wise.profit.index') }}" >{{ ___('reports.parcel_wise_profit') }}</a>
            </li>
            @endif

            @if (hasPermission('panel_report'))
            <li> <a href="{{ route('reports.panel') }}" >{{ ___('menus.panel_report') }}</a> </li>
            @endif

            @if (hasPermission('closing_report'))
            <li> <a href="{{ route('reports.closing') }}" >{{ ___('menus.closing_report') }}</a> </li>
            @endif

            @if (hasPermission('leave_reports'))
            <li> <a href="{{ route('leave.reports') }}" >{{ ___('reports.leave_reports') }}</a> </li>
            @endif

            @if (hasPermission('attendance_reports'))
            <li> <a href="{{ route('attendance.reports') }}" >{{ ___('reports.attendance_reports') }}</a>
            </li>
            @endif

            @if (hasPermission('salary_reports'))
            <li> <a href="{{ route('salary.reports') }}" >{{ ___('reports.salary_reports') }}</a> </li>
            @endif

            @if (hasPermission('vat_reports'))
            <li> <a href="{{ route('vat.reports') }}">{{ ___('reports.vat_reports') }}</a> </li>
            @endif

        </ul>
    </li>
    @endif

    @if (hasPermission('push_notification_read'))
    <li class="d-none "> <a href="{{ route('push-notification.index') }}" ><i class="icon-bell"></i><span class="nav-text">{{ ___('menus.push_notification') }}</span></a> </li>
    @endif




    @if (hasPermission('service_read') ||
    hasPermission('service_faq_read') ||
    hasPermission('home_page_slider_read') ||
    hasPermission('section_read') ||
    hasPermission('page_read') ||
    hasPermission('blog_read') ||
    hasPermission('client_read') ||
    hasPermission('features_read') ||
    hasPermission('team_read') ||
    hasPermission('testimonial_read') ||
    hasPermission('widget_read') ||
    hasPermission('faq_read'))

    <li class="has-submenu {{ request()->is('admin/website-setup/*','admin/website/*') ? 'open' : '' }}">

        <a class="has-arrow" href="javascript:void()" ><i class=" icon-equalizer"></i><span class="nav-text">{{ ___('label.website_setup') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('section_read'))
            <li> <a href="{{ route('section.theme_appearance') }}" >{{ ___('label.theme_appearances') }}</a> </li>
            @endif

            @if (hasPermission('service_read'))
            <li> <a href="{{ route('service.index') }}">{{ ___('label.service') }}</a> </li>
            @endif

            @if (hasPermission('service_faq_read'))
            <li> <a href="{{ route('serviceFaq.index') }}" >{{ ___('label.service_faq') }}</a> </li>
            @endif

             @if (hasPermission('home_page_slider_read'))
                    <li> <a href="{{ route('HomePageSider.index') }}" class="{{ request()->is('admin/website/home-page-slider*') ? 'active' : '' }}">{{ ___('label.home_page_slider') }}</a> </li>
                    @endif

            @if (hasPermission('section_read'))
            <li> <a href="{{ route('section.index') }}" >{{ ___('label.sections') }}</a> </li>
            @endif

            @if (hasPermission('page_read'))
            <li> <a href="{{ route('page.index') }}" >{{ ___('label.pages') }}</a> </li>
            @endif

            @if (hasPermission('blog_read'))
            <li> <a href="{{ route('blog.index') }}" >{{ ___('label.blogs') }}</a> </li>
            @endif

            @if (hasPermission('client_read'))
            <li> <a href="{{ route('client.index') }}" >{{ ___('label.client') }}</a> </li>
            @endif

            @if (hasPermission('features_read'))
            <li> <a href="{{ route('features.index') }}" >{{ ___('label.features') }}</a>
            </li>
            @endif

            @if (hasPermission('team_read'))
            <li> <a href="{{ route('team.index') }}" >{{ ___('label.teams') }}</a> </li>
            @endif

            @if (hasPermission('testimonial_read'))
            <li> <a href="{{ route('testimonial.index') }}" >{{ ___('label.testimonial') }}</a> </li>
            @endif

            @if (hasPermission('social_link_read'))
            <li> <a href="{{ route('socialLink.index') }}" > {{ ___('label.social_link') }} </a> </li>
            @endif

            @if (hasPermission('widget_read'))
            <li> <a href="{{ route('widgets.index') }}" >{{ ___('label.widgets') }}</a> </li>
            @endif

            @if (hasPermission('faq_read'))
            <li> <a href="{{ route('faq.index') }}" >{{ ___('label.faqs') }}</a> </li>
            @endif

            @if (hasPermission('gallery_read'))
            <li> <a href="{{ route('gallery.index') }}" >{{ ___('label.gallery') }}</a> </li>
            @endif
            @if (hasPermission('delivery_area_read'))
            <li> <a href="{{ route('delivery_area.index') }}" >{{ ___('label.delivery_area') }}</a> </li>
            @endif

        </ul>
    </li>
    @endif



    @if (hasPermission('fraud_read'))
    <li > <a href="{{ route('fraud.index') }}" ><i class="icon-check"></i><span class="nav-text">{{ ___('menus.fraud_check') }}</span></a>
    </li>
    @endif

    @if (hasPermission('subscribe_read'))
    <li> <a class="" href="{{ route('subscribe.index') }}" ><i class="icon-like"></i><span class="nav-text">{{ ___('account.subscribe') }}</span></a> </li>
    @endif

    @if (hasPermission('support_read'))
    <li> <a href="{{ route('support.index') }}" ><i class="icon-support"></i><span class="nav-text">{{ ___('menus.support') }}</span></a>
    </li>
    @endif

    @if (hasPermission('log_read'))
    <li> <a  href="{{ route('logs.index') }}" class=""><i class="icon-list"></i><span class="nav-text">{{ ___('menus.active_logs') }}</span></a> </li>
    @endif



    @if(hasPermission('app_slider_read') )
    <li > <a href="{{route('app_slider.index')}}"><i class=" icon-location-pin"></i><span class="nav-text">{{ ___('menus.app_slider')}}</span></a> </li>
    @endif

    @if (hasPermission('contact_us_read'))
    <li >
        <a href="{{ route('contactUs.index') }}" ><i class="icon-envelope"></i><span class="nav-text">{{ ___('menus.contact_us_messages') }}</span></a>
    </li>
    @endif

    @if (hasPermission('todo_read'))
    <li >
        <a href="{{ route('todo.index') }}" ><i class="icon-notebook"></i><span class="nav-text">{{ ___('menus.todo_list') }}</span></a>
    </li>
    @endif



    @if (hasPermission('language_read'))
    <li ><a href="{{ route('language.index') }}" aria-expanded="true"><i class="icon-globe"></i><span class="nav-text">{{ ___('menus.languages') }}</span></a></li>
    @endif



    @if (hasPermission('general_settings_read') ||
    hasPermission('recaptcha_settings_read') ||
    hasPermission('mail_settings_read') ||
    hasPermission('pickup_read') ||
    hasPermission('sms_settings_read') ||
    hasPermission('sms_send_settings_read') ||
    hasPermission('social_login_settings_update') ||
    hasPermission('social_login_settings_update') ||
    hasPermission('payment_gateway_settings_read') ||
    hasPermission('database_backup_read'))

    <li class="has-submenu">
        <a class="has-arrow" href="javascript:void()" ><i class="icon-wrench"></i><span class="nav-text">{{ ___('menus.settings') }}</span></a>
        <ul class="submenu">

            @if (hasPermission('general_settings_read'))
            <li> <a href="{{ route('settings.general.index') }} "  >{{ ___('menus.general_settings') }}</a> </li>
            @endif

            @if (hasPermission('mail_settings_read'))
            <li> <a href="{{ route('settings.mail.index') }}"  >{{ ___('menus.mail_setting') }}</a> </li>
            @endif

            @if (hasPermission('pickup_read'))

            <li> <a href="{{ route('pickup.index') }}"  @class(['active' => request()->is('admin/settings/pickup-slot/*')])>{{ ___('menus.pickup_slot') }}</a> </li>

            @endif

            @if (hasPermission('sms_settings_read'))
            <li> <a href="{{ route('sms-settings.index') }}" >{{ ___('menus.sms_settings') }}</a>
            </li>
            @endif

            {{-- @if (hasPermission('sms_send_settings_read'))
            <li> <a href="{{route('sms-send-settings.index')}}" class="{{ (request()->is('admin/settings/sms-send')) ? 'active' : '' }}">{{ ___('menus.sms_send_settings') }}</a>
    </li>
    @endif --}}

        @if (hasPermission('social_login_settings_read'))
        <li> <a href="{{ route('social.login.settings.index') }}" >{{ ___('menus.social_login_settings') }}</a>
        </li>
        @endif

        @if (hasPermission('recaptcha_settings_read'))
        <li><a href="{{ route('settings.recaptcha') }}"  >{{ ___('menus.recaptcha') }}</a></li>
        @endif

        @if (hasPermission('payment_gateway_settings_read'))
        <li class="d-none"> <a href="{{ route('settings.paymentGateway') }}" >{{ ___('menus.payment_gateway') }}</a> </li>
        @endif

        @if (hasPermission('database_backup_read'))
        <li> <a href="{{ route('database.backup.index') }}" >{{ ___('menus.database_backup') }}</a> </li>
        @endif

    </ul>
</li>


@endif
</ul>

<!--********************************** Sidebar end ***********************************-->
