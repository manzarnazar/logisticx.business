@extends('backend.partials.master')
@section('title')
{{ ___('menus.profile') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">

    <div class="j-profile-main">
        <div class="row">
            <div class="col-lg-6">
                <div class="row page-titles mx-0">
                    <div class="col-sm-10 p-md-0">
                        <div class="welcome-text wel-flex">
                            <div class="wel-user-pic">
                                <img src="{{ getImage($user->upload, 'original','default-image-40x40.png') }}" class="profile-img" alt="">
                            </div>
                            <div class="wel-user-bio">
                                <h5 class="heading-5">{{@$user->name}}</h5>
                                <p class="mb-0">{{@$user->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        @if($user->id == auth()->user()->id)
                        <a href="{{ route('profile.update') }}" id="edit" class="j-btn-sm">{{ ___('label.edit') }}</a>
                        @endif
                    </div>
                </div>
                <div class="j-eml-card">
                    <h5 class="heading-5">{{ ___('common.basic_information')}}</h5>
                    <ul class="j-eml-list">
                        <li>
                            <h6 class="heading-6">{{ ___('label.name')}}</h6>
                            <span>{{@$user->name}}</span>
                        </li>

                        @if(@$user->merchant)
                        <li>
                            <h6 class="heading-6">{{ ___('label.business_name') }}</h6>
                            <span>{{ @$user->merchant->business_name }}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('label.unique_id') }}</h6>
                            <span>{{@$user->merchant->merchant_unique_id}}</span>
                        </li>


                        <li>
                            <h6 class="heading-6">{{ ___('label.vat') }}</h6>
                            <span>{{ @settings('currency') }} {{ @$user->merchant->vat }}</span>
                        </li>

                        <li>
                            <h6 class="heading-6"> {{ ___('merchant.shop') }}</h6>
                            <span>{{@$user->merchant->activeShops->count()}} {{ ___('merchant.active_shop') }}</span>
                        </li>

                        <li>
                            <h6 class="heading-6">{{ ___('menus.coverage') }}</h6>
                            <span>{{@$user->merchant->coverage->name}}</span>
                        </li>


                        @endif

                        <li>
                            <h6 class="heading-6">{{ ___('label.nid') }}</h6>
                            <span>{{ @$user->nid_number }}</span>
                        </li>

                        @if (auth()->user()->user_type != \App\Enums\UserType::MERCHANT )
                        <li>
                            <h6 class="heading-6">{{ ___('label.salary') }}</h6>
                            <span>{{ @$user->salary }}</span>
                        </li>
                        @endif

                        <li>
                            <h6 class="heading-6">{{ ___('label.status') }}</h6>
                            <span>{!! @$user->my_status !!}</span>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="col-lg-6" id="update">
                <div class="card card-border profile-pd-0">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="{{route('profile')}}" class="nav-link {{ Route::currentRouteName() == 'profile'?'active':''}}">{{ ___('label.contact_info') }}</a> </li>
                                    <li class="nav-item"><a href="{{route('profile.update')}}" class="nav-link {{ Route::currentRouteName() == 'profile.update'?'active':''}}">{{ ___('label.update_profile') }}</a> </li>
                                    <li class="nav-item"><a href="{{route('password.update')}}" class="nav-link {{ Route::currentRouteName() == 'password.update'?'active':''}}">{{ ___('label.update_password') }}</a> </li>
                                </ul>
                                <div class="tab-content">

                                    @yield('content')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- end wrapper  -->
@endsection()
