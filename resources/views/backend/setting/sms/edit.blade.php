@extends('backend.partials.master')
@section('title')
{{ ___('settings.sms_settings') }} {{ ___('label.edit') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('sms-settings.index') }}" class="breadcrumb-link">{{ ___('settings.sms_settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="j-create-main">
        <form action="{{route('sms-settings.update',$smsSetting->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('settings.sms_settings') }}
                        </div>

                        <div class="form-row">

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="gateway">{{ ___('settings.gateway') }}</label>
                                <input id="gateway" type="text" name="gateway" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_gateway_name') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('gateway',$smsSetting->gateway)}}">
                                @error('gateway')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="secret_key">{{ ___('settings.secret_key') }}</label>
                                <input id="secret_key" type="text" name="secret_key" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_secret_key') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('secret_key',$smsSetting->secret_key)}}">
                                @error('secret_key')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="api_key">{{ ___('settings.api_key') }}</label>
                                <input id="api_key" type="text" name="api_key" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_api_key') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('api_key',$smsSetting->api_key)}}">
                                @error('api_key')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="api_url">{{ ___('settings.api_url') }}</label>
                                <input id="api_url" type="url" name="api_url" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_api_url') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('api_url',$smsSetting->api_url)}}">
                                @error('api_url')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="username">{{ ___('settings.username') }}</label>
                                <input id="username" type="text" name="username" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_username') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('username',$smsSetting->username)}}">
                                @error('username')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="user_password">{{ ___('settings.user_password') }}</label>
                                <input id="user_password" type="text" name="user_password" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_user_password') }}" autocomplete="off" class="form-control input-style-1 " value="{{old('user_password',$smsSetting->user_password)}}">
                                @error('user_password')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="status">{{ ___('label.status') }}</label>
                                <select name="status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',$smsSetting->status) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('sms-settings.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>






</div>
@endsection()
