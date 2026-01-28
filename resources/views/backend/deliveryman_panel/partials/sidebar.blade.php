<!--**********************************
            Sidebar start
        ***********************************-->


        <ul >

            <li><a class="{{ request()->is('dashboard') ? 'active' : '' }}" href="{{route('dashboard.index')}}" ><i class="icon-chart"></i><span class="nav-text">{{___('menus.dashboard')}}</span></a></li>

            @if(hasPermission('language_read'))
            <li ><a class="{{ (request()->is('admin/language*')) ? 'active' : '' }}" href="{{route('language.index')}}" ><i class="fa-solid fa-earth-americas"></i><span class="nav-text">{{ ___('menus.languages')}}</span></a></li>
            @endif
            <li class="has-submenu " >
                <a class="has-arrow" href="javascript:void()" ><i class="icon-bag"></i><span class="nav-text">{{ ___('menus.parcel_manage') }}</span></a>
                <ul class="submenu">

                        <li >
                            <a  href="{{route('parcel.index')}}" ><i class="icon-bag"></i><span class="nav-text">{{ ___('menus.all_parcel') }}</span></a>
                        </li>
                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'pickup-assign']) }}" ><i class="icon-user-follow"></i><span class="nav-text">{{ ___('parcel.pickup_assign') }}</span></a>
                        </li>

                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'received-warehouse']) }}" ><i class="icon-check"></i><span class="nav-text">{{ ___('parcel.received_warehouse') }}</span></a>
                        </li>

                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'delivery-man-assign']) }}" ><i class="icon-user-following"></i><span class="nav-text">{{ ___('parcel.deliveryman_assign') }}</span></a>
                        </li>


                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'delivered']) }}" ><i class="icon-check"></i><span class="nav-text">{{ ___('parcel.delivered') }}</span></a>
                        </li>

                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'partial-delivered']) }}" ><i class="fa-solid fa-list-check"></i><span class="nav-text">{{ ___('parcel.partial_delivered') }}</span></a>
                        </li>

                        <li >
                            <a  href="{{ route('parcel.index',['slug' => 'return-assign-to-merchant']) }}" ><i class="fa-solid fa-rotate-left"></i><span class="nav-text">{{ ___('parcel.return_assign_to_merchant') }}</span></a>
                        </li>


                </ul>
            </li>

            <li class="has-submenu {{ request()->routeIs('deliveryman.panel.reports.*') ? 'open' : '' }}">
                <a class="has-arrow" href="javascript:void()" ><i class="icon-docs"></i><span class="nav-text">{{ ___('reports.title') }}</span></a>
                <ul class="submenu">
                    <li> <a class="{{ request()->routeIs('deliveryman.panel.reports.closing.report') ? 'active' : '' }}"
                          href="{{route('deliveryman.panel.reports.closing.report')}}">{{ ___('menus.closing_report') }}</a> </li>
                </ul>
            </li>

            <li ><a class="{{ (request()->is('profile*')) ? 'active' : '' }}" href="{{route('profile')}}" ><i class="icon-user"></i><span class="nav-text">{{ ___('menus.my_profile')}}</span></a></li>


        </ul>



<!--**********************************
            Sidebar end
        ***********************************-->
