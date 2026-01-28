@extends('backend.partials.master')

@section('title',___('menus.Recaptcha settings') )

@section('maincontent')

<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('dashboard.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('settings.recaptcha') }}" class="breadcrumb-link active">{{ ___('menus.recaptcha') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- basic form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('menus.recaptcha') }}</h4>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="site_key">{{ ___('label.site_key') }}</label>
                                <input type="text" placeholder="{{ ___('placeholder.enter_site_key') }}" class="form-control input-style-1" name="recaptcha_site_key" value="{{ old('recaptcha_site_key',settings('recaptcha_site_key')) }}" @if(!hasPermission('recaptcha_settings_update')) disabled @endif>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="secret_key">{{ ___('label.secret_key') }}</label>
                                <input type="text" placeholder="{{ ___('placeholder.enter_secret_key') }}" class="form-control input-style-1" name="recaptcha_secret_key" value="{{ old('recaptcha_secret_key',settings('recaptcha_secret_key')) }}" @if(!hasPermission('recaptcha_settings_update')) disabled @endif>
                                @error('secret_key') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="recaptcha_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="recaptcha_status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('recaptcha_status', settings('recaptcha_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('recaptcha_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i>{{ ___('label.update') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>

@endsection
