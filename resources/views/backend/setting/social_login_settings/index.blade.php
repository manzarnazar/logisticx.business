@extends('backend.partials.master')
@section('title')
{{ ___('menus.social_login_settings') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('social.login.settings.index')}}" class="breadcrumb-link active">{{ ___('menus.social_login_settings') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="h4 mb-3">{{ ___('label.facebook')}}</h4>
                    @if(hasPermission('social_login_settings_update'))
                    <form action="{{route('social.login.settings.update','facebook')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        @endif
                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="facebook_client_id">{{ ___('label.app_id') }}<span class="text-danger">*</span> </label>
                                <input id="facebook_client_id" type="text" name="facebook_client_id" placeholder="{{ ___('placeholder.app_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('facebook_client_id', settings('facebook_client_id')) }}" require>
                                @error('facebook_client_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="facebook_client_secret">{{ ___('label.app_secret') }}<span class="text-danger">*</span> </label>
                                <input id="facebook_client_secret" type="text" name="facebook_client_secret" placeholder="{{ ___('placeholder.app_secret') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('facebook_client_secret', settings('facebook_client_secret')) }}" require>
                                @error('facebook_client_secret')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div> 
                            
                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="facebook_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="facebook_status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('facebook_status', settings('facebook_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('facebook_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        @if(hasPermission('social_login_settings_update'))
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-6  col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="h4 mb-3">{{ ___('label.google')}}</h4>
                    @if(hasPermission('social_login_settings_update'))
                    <form action="{{route('social.login.settings.update','google')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        @endif
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label class="label-style-1" for="google_client_id">{{ ___('label.client_id') }}<span class="text-danger">*</span> </label>
                                <input id="google_client_id" type="text" name="google_client_id" placeholder="{{ ___('placeholder.client_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('google_client_id', settings('google_client_id')) }}" require>
                                @error('google_client_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12">
                                <label class="label-style-1" for="google_client_secret">{{ ___('label.client_secret') }}<span class="text-danger">*</span> </label>
                                <input id="google_client_secret" type="text" name="google_client_secret" placeholder="{{ ___('placeholder.client_secret') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('google_client_secret', settings('google_client_secret')) }}" require>
                                @error('google_client_secret') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="google_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="google_status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('google_status', settings('google_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('google_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        @if(hasPermission('social_login_settings_update'))
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
