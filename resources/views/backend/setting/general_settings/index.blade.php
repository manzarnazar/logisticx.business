@extends('backend.partials.master')
@section('title')
{{ ___('menus.general_settings') }}
@endsection
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
                            <li class="breadcrumb-item"><a href="{{ route('settings.general.index') }}" class="breadcrumb-link active">{{ ___('menus.general_settings') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('menus.general_settings') }}</h4>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="name">{{ ___('label.name') }}</label>
                                <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{ old('name', settings('name')) }}" require>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="phone">{{ ___('label.phone') }}</label>
                                <input id="phone" type="text" name="phone" placeholder="{{ ___('placeholder.Enter_phone') }}" class="form-control input-style-1" value="{{ old('phone', settings('phone')) }}" require>
                                @error('phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="email">{{ ___('label.email') }}</label>
                                <input id="email" type="text" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1" value="{{ old('email', settings('email')) }}" require>
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="address">{{ ___('label.address') }}</label>
                                <input id="address" type="text" name="address" placeholder="{{ ___('placeholder.address') }}" class="form-control input-style-1" value="{{ old('address', settings('address')) }}" require>
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="open_hours">{{ ___('label.open_hours') }}</label>
                                <input id="open_hours" type="text" name="open_hours" placeholder="{{ ___('placeholder.open_hours') }}" class="form-control input-style-1" value="{{ old('open_hours', settings('open_hours')) }}" require>
                                @error('open_hours') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="official_message">{{ ___('label.official_message') }}</label>
                                <input id="official_message" type="text" name="official_message" placeholder="{{ ___('placeholder.official_message') }}" class="form-control input-style-1" value="{{ old('official_message', settings('official_message')) }}" require>
                                @error('official_message') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="default_language" class="label-style-1">{{ ___('label.default_language') }} <span class="text-danger">*</span></label>
                                <select name="default_language" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach ($languages ?? [] as $language )
                                    <option value="{{ $language->code}}" @selected($language->code == settings('default_language'))>{{ $language->name }}</option>
                                    @endforeach
                                </select>
                                @error('default_language') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.date_format') }} <span class="text-danger">*</span></label>
                                <select name="date_format" class="form-control input-style-1 select2">
                                    @foreach(config('site.date_format') as $format)
                                    <option value="{{ $format }}" @selected(old('date_format',settings('date_format'))==$format)>{{ today()->setTimezone(settings('timezone'))->format($format) }}</option>
                                    @endforeach

                                </select>
                                @error('date_format') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.time_format') }} <span class="text-danger">*</span></label>
                                <select name="time_format" class="form-control input-style-1 select2">
                                    @foreach( config('site.time_format') as $format)
                                    <option value="{{ $format }}" @selected(old('time_format',settings('time_format'))==$format)>{{ now()->setTimezone(settings('timezone'))->format($format) }} </option>
                                    @endforeach
                                </select>

                                @error('time_format') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="paginate_value">{{ ___('label.paginate_value') }}</label>
                                <input id="paginate_value" type="number" name="paginate_value" placeholder="{{ ___('placeholder.paginate_value') }}" class="form-control input-style-1" value="{{ old('paginate_value', settings('paginate_value')) }}" require>
                                @error('paginate_value') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="currency">{{ ___('label.currency') }}</label>
                                <select class="form-control input-style-1 select2" id="currency" name="currency" required>
                                    <option></option>
                                    @foreach ($currencies as $currency)
                                    <option value="{{$currency->symbol }}" @selected(old('currency',settings('currency') )==$currency->symbol )>{{$currency->name . ' - ' . $currency->symbol }}</option>
                                    @endforeach
                                </select>
                                @error('currency') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="par_track_prefix">{{ ___('settings.parcel_tracking') }} {{ ___('label.prefix') }}</label>
                                <input type="text" name="par_track_prefix" class="form-control input-style-1" placeholder="Enter Parcel Tracking Prefix" value="{{ old('par_track_prefix', settings('par_track_prefix')) }}" />
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.favicon') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{ favicon(settings('favicon')) }}" alt="favicon">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholder2tt" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="favicon">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="favicon" id="favicon" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.light_logo') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholderhtt" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="light_logo">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="light_logo" id="light_logo" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>

                                <div class="col-6 text-right p-1">
                                    <img src="{{ logo(settings('light_logo')) }}" alt="logo" class="h-50px object-fit-cover">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.dark_logo') }} <span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholderhtt" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="dark_logo">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="dark_logo" id="dark_logo" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>

                                <div class="col-6 text-right bg-dark p-1">
                                    <img src="{{ logo(settings('dark_logo')) }}" alt="Logo" class="h-50px object-fit-cover">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.app')}} {{ ___('label.light_logo') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholderhtt" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="app_light_logo">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="app_light_logo" id="app_light_logo" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>

                                <div class="col-6 text-right p-1">
                                    <img src="{{ logo(settings('app_light_logo')) }}" alt="logo" class="h-50px object-fit-cover">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.app')}} {{ ___('label.dark_logo') }} <span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholderhtt" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="app_dark_logo">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="app_dark_logo" id="app_dark_logo" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>

                                <div class="col-6 text-right bg-dark p-1">
                                    <img src="{{ logo(settings('app_dark_logo')) }}" alt="Logo" class="h-50px object-fit-cover">
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="copyright">{{ ___('label.copyright') }}</label>
                                <input id="copyright" type="text" name="copyright" placeholder="{{ ___('placeholder.Enter_copyright') }}" class="form-control input-style-1" value="{{ old('copyright', settings('copyright')) }}" require>
                                @error('copyright') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- ========== App Version & Links ========== --}}
<div class="col-12">
    <h5 class="mt-4 mb-2"><i class="fa fa-mobile-screen-button me-2"></i> {{ ___('label.app_version_control') }}</h5>
    <hr>
</div>

<div class="form-group col-md-4">
    <label class="label-style-1" for="latest_app_version">
        {{ ___('label.latest_app_version') }}
    </label>
    <input type="text" name="latest_app_version"
           id="latest_app_version"
           class="form-control input-style-1"
           placeholder="e.g. 1.6.0"
           value="{{ old('latest_app_version', settings('latest_app_version')) }}">
    @error('latest_app_version') 
        <small class="text-danger mt-2">{{ $message }}</small> 
    @enderror
</div>

<div class="form-group col-md-4">
    <label class="label-style-1" for="android_download_url">
        {{ ___('label.android_download_url') }}
    </label>
    <input type="text" name="android_download_url"
           id="android_download_url"
           class="form-control input-style-1"
           placeholder="https://play.google.com/store/apps/details?id=com.yourapp"
           value="{{ old('android_download_url', settings('android_download_url')) }}">
    @error('android_download_url') 
        <small class="text-danger mt-2">{{ $message }}</small> 
    @enderror
</div>

<div class="form-group col-md-4">
    <label class="label-style-1" for="ios_download_url">
        {{ ___('label.ios_download_url') }}
    </label>
    <input type="text" name="ios_download_url"
           id="ios_download_url"
           class="form-control input-style-1"
           placeholder="https://apps.apple.com/app/id123456789"
           value="{{ old('ios_download_url', settings('ios_download_url')) }}">
    @error('ios_download_url') 
        <small class="text-danger mt-2">{{ $message }}</small> 
    @enderror
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
@endsection()
