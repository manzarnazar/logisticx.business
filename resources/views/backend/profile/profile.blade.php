@extends('backend.profile.master')
@section('title')
{{ ___('menus.profile') }}
@endsection
@section('content')
<div id="update_profile">
    <div class="settings-form j-text-body">
        <ul class="j-eml-list">
            <li>
                <h6 class="heading-6">{{ ___('label.email')}}</h6>
                <span>
                    {{@$user->email}}
                    @if(@$user->email_verified_at==null)
                    <i class="fa-solid fa-circle-exclamation text-danger" title="{{ ___('alert.email_not_verified') }}"></i>
                    @endif
                </span>

            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.phone')}}</h6>
                <span>{{@$user->mobile}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.address')}}</h6>
                <span>{{@$user->address}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.role') }}</h6>
                <span>{{@$user->role->name}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.designation') }}</h6>
                <span>{{@$user->designation->name}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.hub') }}</h6>
                <span>{{@$user->hub->name}}</span>
            </li>
            <li>
                <h6 class="heading-6">{{ ___('label.joining_date') }}</h6>
                <span>{{ dateFormat(@$user->joining_date) }}</span>
            </li>
        </ul>
    </div>
</div>
@endsection()
