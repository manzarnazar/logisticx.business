
<div class="navbar">
    <div class="logo-container">
        <a href="{{ route('home') }}" class="logo d-none d-md-block">
            <img loading="lazy" class="logo-light" src="{{ logo(settings('dark_logo')) }}" alt="Logo" class="w-100" />
            <img loading="lazy" class="logo-dark" src="{{ logo(settings('light_logo')) }}"
                alt="Logo" class="w-100" />
        </a>
        <a class="logo d-block d-md-none" href="{{ route('home') }}"> <img loading="lazy"
                src="{{ favicon(settings('favicon')) }}" alt="Logo" /> </a>

        <div class="d-flex align-items-center">
            <button class="toggle-btn bg-transparent flex-shrink-0" id="toggleSidebar">☰</button>
        </div>
        {{-- <a class="logo d-lg-none" href="{{ url('/')}}"> <img loading="lazy" src="{{ getImage(globalSettings('favicon'),'image_one') }}" alt="Logo" /> </a> --}}
    </div>

    <div class="navbar-right-container d-flex justify-content-between align-items-center">
        <div class="right-content ml-auto">
            <form class="j-search-form d-none d-lg-block" action="{{ route('search') }}">
                <input class="j-form-control" type="text" placeholder="{{___('placeholder.search')}}" name="q" id="search" list="route_list" data-url="{{ route('search.route') }}">
                <datalist id="route_list"> </datalist>
                <button type="submit" class="j-form-btn"> <i class="icon-magnifier"></i> </button>
            </form>

            @if(hasPermission('todo_create')== true)
                <div class="j-to-do d-none d-sm-block">
                    <a href="#" class="j-td-btn" id="todoModal1" data-target="#todoModal" data-toggle="modal" data-url="{{route('todo.modal')}}">
                        <img src="{{asset('backend/icons/icon/to-do.png')}}" class="jj" alt="no image" />
                        <span class="d-none d-xl-block">{{ ___('common.to_do')}}</span>
                    </a>
                </div>
            @endif

            <div class="nav-lang">
                <div class="dropdown custom-dropdown">
                    <button type="button" class="btn-ami" data-toggle="dropdown">
                        <i class="{{ defaultLanguage()->icon_class }}"></i><span class="d-none d-xl-block">{{ Str::upper(defaultLanguage()->code) }}</span><i class="fa fa-angle-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach ($languages as $lang)
                        <a class="dropdown-item" href="{{ route('setlocalization', $lang->code) }}"> <i class="{{ @$lang->icon_class }}"></i> {{ @$lang->name }} </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <button id="day-night-icon" class="nav-bell bg-transparent">
                <i id="theme-icon" class="{{ session('theme') == 'dark'? 'ti-shine text-white':'fa-solid fa-moon' }}"></i>
            </button>


            <div class="dropdown notification_dropdown">
                <a class="j-nav-lk" href="#" role="button" data-toggle="dropdown">
                    <i class="nav-bell"> <img src="{{asset('backend/icons/icon/bell.png')}}" alt="no image" /> </i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="list-unstyled">

                        @forelse ( auth()->user()->unreadNotifications->take(5)->sortByDesc('created_at') as $notify )

                        <li class="media dropdown-item m-0 p-2">
                            {{-- <span class="success p-2"> <img src="{{ getImage(singleUser($notify->data['user_id'])->user->upload, 'original','default-image-40x40.png' ) }}" alt="" height="100%"> </span> --}}
                            <div class="media-body">
                                <a href="{{ $notify->data['url'] }}">
                                    <p> <strong>{{ $notify->data['name'] }} </strong> {{ $notify->data['message'] }} </p>
                                </a>
                            </div>
                            <span class="notify-time">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$notify->created_at)->diffForHumans() }}</span>
                        </li>
                        @empty
                        <li class="media dropdown-item"> <Span>{{ ___('alert.no_notification_available')}}</Span> </li>
                        @endforelse

                    </ul>
                    <a class="all-notification" href="{{route('notification.index')}}"> {{ ___('label.see_all_notification') }} <i class="ti-arrow-right"></i> </a>
                </div>
            </div>

            <!--------- Dark mode Start --------  -->
{{-- 
            <button type="button" class="dark-btn nav-bell bg-transparent">
                <svg class="moon-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon-icon lucide-moon"><path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.46.402.803a6 6 0 0 0 8.268 8.268c.344-.215.825-.004.803.401"/></svg>
                <svg class="sun-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun-icon lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
            </button> --}}

            <!--------- Dark mode Ends --------  -->

            <div class="dropdown header-profile">
                <a class="nav-np" href="#" role="button" data-toggle="dropdown">
                    <img src="{{ getImage(auth()->user()->upload, 'original','default-image-40x40.png' ) }}" class="np" alt="" />
                    <h6 class="heading-6 mb-0 d-none d-xl-block"> {{ auth()->user()->name }} </h6>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{route('profile')}}" class="dropdown-item">
                        <i class="icon-user"></i> <span class="ml-2">{{ ___('menus.profile') }} </span>
                    </a>
                    <a href="{{route('password.update')}}" class="dropdown-item">
                        <i class=" icon-key"></i> <span class="ml-2">{{ ___('menus.change_password') }} </span>
                    </a>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="icon-logout"></i> <span class="ml-2">{{ ___('menus.logout') }} </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>





@include('backend.todo.to_do_list')

<!--********************************** Header end ti-comment-alt *********************************** -->

