<!--********************************** Sidebar start ***********************************-->

<ul>
    <li> <a class="{{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard.index') }}"> <i
                class="icon-chart"></i><span class="nav-text">{{ ___('menus.dashboard') }}</span> </a> </li>

    <li>
        <a class="{{ request()->is('parcel') ? 'active' : '' }}" href="{{ route('parcel.index') }}"><i
                class="ti-gift"></i><span class="nav-text">{{ ___('menus.parcel') }}</span></a>
    </li>
    <li> <a class="{{ request()->is('merchant/parcel-bank/index') ? 'active' : '' }}"
            href="{{ route('merchant-panel.parcel-bank.index') }}"><i class="icon-social-dropbox"></i><span
                class="nav-text">{{ ___('menus.parcel_bank') }}</span></a> </li>

    <li>
        <a class="{{ request()->is('*shops*') ? 'active' : '' }}" href="{{ route('merchant-panel.shops.index') }}"><i
                class="icon-home"></i><span class="nav-text">{{ ___('menus.shops') }}</span></a>
    </li>

    <li>
        <a class="{{ request()->is('*support/*') ? 'active' : '' }}" href="{{ route('support.index') }}"><i
                class="fa-solid fa-headset"></i><span class="nav-text">{{ ___('menus.support') }}</span></a>
    </li>

    <li>
        <a class="{{ request()->is('*payment-request*') ? 'active' : '' }}"href="{{ route('merchant-panel.payment-request.index') }}"><i class="icon-credit-card"></i><span class="nav-text">{{ ___('menus.payments') }}</span></a>
    </li>

    <li>
        <a class="{{ request()->is('payment/accounts') ? 'active' : '' }}"href="{{ route('merchant.payment.account.index') }}"><i class="icon-wallet"></i><span class="nav-text">{{ ___('menus.accounts') }}</span></a>
    </li>

    <li class="has-submenu {{ request()->is('admin/charges/charge/*')? 'open' : '' }}"><a class="has-arrow" href="javascript:void()"><i class=" icon-drawar"></i><span class="nav-text">{{ ___('menus.charges') }}</span></a>
        <ul class="submenu">
            <li> <a href="{{ route('charge.index') }}"class="{{ request()->routeIs('charge.index') ? 'active' : '' }}">{{ ___('menus.general_charges') }}</a>
            </li>
            <li> <a href="{{ route('merchant.my_charge') }}"class="{{ request()->routeIs('merchant.my_charge') ? 'active' : '' }}">{{ ___('menus.my_charges') }}</a>
            </li>
            <li> <a href="{{ route('cod-and-others') }}"class="{{ request()->routeIs('cod-and-others') ? 'active' : '' }}">{{ ___('menus.cod_charges') }}</a>
            </li>
        </ul>
    </li>

    <li class="has-submenu {{ request()->is('merchant/reports/*') || request()->is('merchant/accounts/*') ? 'open' : '' }}"><a class="has-arrow" href="javascript:void()"><i class="icon-docs"></i><span
                class="nav-text">{{ ___('reports.title') }}</span></a>
        <ul class="submenu">
            <li> <a href="{{ route('merchant-panel.parcel.reports') }}"class="{{ request()->routeIs('merchant-panel.parcel.reports') ? 'active' : '' }}">{{ ___('reports.parcel_reports') }}</a>
            </li>
            <li> <a href="{{ route('merchant.report.closing') }}"class="{{ request()->routeIs('merchant.report.closing') ? 'active' : '' }}">{{ ___('menus.closing_report') }}</a>
            </li>
            <li> <a href="{{ route('merchant.accounts.account-transaction.index') }}"class="{{ request()->routeIs('merchant.accounts.account-transaction.index') ? 'active' : '' }}">{{ ___('menus.account_transaction') }}</a>
            </li>
        </ul>
    </li>
</ul>


<!--********************************** Sidebar end ***********************************-->
