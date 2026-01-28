@extends('backend.partials.master')
@section('title')
{{ ___('menus.payout_settings') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link ">{{ ___('menus.settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('menus.payment_gateway') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        {{-- PAYPAL --}}
        <div class="col-lg-6  col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('Paypal') }} </h4>
                    </div>

                    @if(hasPermission('payout_setup_settings_update'))
                    <form action="{{route('payout.setup.settings.update',\App\Enums\PayoutSetup::PAYPAL)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        @endif
                        <div class="form-row">

                            <div class="form-group col-12">
                                <label class="label-style-1" for="paypal_client_id">{{ ___('label.paypal_client_id') }}<span class="text-danger">*</span> </label>
                                <input id="paypal_client_id" type="text" name="paypal_client_id" data-parsley-trigger="change" placeholder="{{ ___('label.paypal_client_id') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('paypal_client_id', settings('paypal_client_id')) }}" require>
                                @error('paypal_client_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <label class="label-style-1" for="paypal_client_secret">{{ ___('label.paypal_client_secret') }}<span class="text-danger">*</span> </label>
                                <input id="paypal_client_secret" type="text" name="paypal_client_secret" data-parsley-trigger="change" placeholder="{{ ___('label.paypal_client_secret') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('paypal_client_secret', settings('paypal_client_secret')) }}" require>
                                @error('paypal_client_secret')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <label class="label-style-1" for="paypal_mode">{{ ___('label.test_mode') }}<span class="text-danger">*</span> </label>
                                <input id="paypal_mode" type="text" name="paypal_mode" data-parsley-trigger="change" placeholder="{{ ___('label.paypal_mode') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('paypal_mode', settings('paypal_mode')) }}" require>
                                @error('paypal_mode')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- <div class="form-group col-md-12">
                            <label class="label-style-1" for="paypal_mode">{{ ___('label.test_mode') }}<span class="text-danger">*</span> </label>
                            <select name="paypal_mode" class="form-control input-style-1  select2">
                                @foreach(config('site.status.default') as $key => $status)
                                <option value="{{ $key }}" @selected(old('paypal_mode', settings('paypal_mode'))==$key)>{{ ___('common.'.  $status) }}</option>
                                @endforeach
                            </select>
                            @error('paypal_mode') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div> --}}


                        <div class="form-group col-md-12">
                            <label class="label-style-1" for="paypal_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                            <select name="paypal_status" class="form-control input-style-1  select2">
                                @foreach(config('site.status.default') as $key => $status)
                                <option value="{{ $key }}" @selected(old('paypal_status', settings('paypal_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                                @endforeach
                            </select>
                            @error('paypal_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>



                        {{-- <div class="form-group col-12 d-flex">
                            <label class="label-style-1" for="switch-id">{{ ___('label.status') }}</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input switch-id ml-3" name="paypal_status" id="switch-id" type="checkbox" role="switch" @if(old('paypal_status', settings('paypal_status'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                        </div>
                </div> --}}

            </div>

            @if(hasPermission('payout_setup_settings_update'))
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

{{-- SSL Commerz --}}
<div class="col-lg-6  col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('SSL Commerz') }} </h4>
            </div>

            @if(hasPermission('payout_setup_settings_update'))
            <form action="{{route('payout.setup.settings.update',\App\Enums\PayoutSetup::SSL_COMMERZ)}}" method="POST" enctype="multipart/form-data" id="basicform">
                @method('PUT')
                @csrf
                @endif
                <div class="row">

                    <div class="form-group col-12">
                        <label class="label-style-1" for="sslcommerz_store_id">{{ ___('label.sslcommerz_store_id') }}<span class="text-danger">*</span> </label>
                        <input id="sslcommerz_store_id" type="text" name="sslcommerz_store_id" data-parsley-trigger="change" placeholder="{{ ___('label.sslcommerz_store_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('sslcommerz_store_id', settings('sslcommerz_store_id')) }}" require>
                        @error('sslcommerz_store_id')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label class="label-style-1" for="sslcommerz_store_password">{{ ___('label.sslcommerz_store_password') }}<span class="text-danger">*</span> </label>
                        <input id="sslcommerz_store_password" type="text" name="sslcommerz_store_password" data-parsley-trigger="change" placeholder="{{ ___('label.sslcommerz_store_password') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('sslcommerz_store_password', settings('sslcommerz_store_password')) }}" require>
                        @error('sslcommerz_store_password')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="label-style-1" for="sslcommerz_testmode">{{ ___('label.test_mode') }}<span class="text-danger">*</span> </label>
                        <select name="sslcommerz_testmode" class="form-control input-style-1  select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('sslcommerz_testmode', settings('sslcommerz_testmode'))==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('sslcommerz_testmode') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="label-style-1" for="sslcommerz_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                        <select name="sslcommerz_status" class="form-control input-style-1  select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('sslcommerz_status', settings('sslcommerz_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('sslcommerz_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    {{-- <div class="form-group col-12 d-flex">
                        <label class="label-style-1" for="switch-id">{{ ___('label.test_mode') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-id ml-3" name="sslcommerz_testmode" id="switch-id" type="checkbox" role="switch" @if(old('sslcommerz_testmode', settings('sslcommerz_testmode'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                    </div>
                </div>


                <div class="form-group col-12 d-flex">
                    <label class="label-style-1" for="switch-id">{{ ___('label.status') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-id ml-3" name="sslcommerz_status" id="switch-id" type="checkbox" role="switch" @if(old('sslcommerz_status', settings('sslcommerz_status'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                    </div>
                </div> --}}

        </div>

        @if(hasPermission('payout_setup_settings_update'))
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

{{-- BKASH --}}
<div class="col-lg-6  col-md-6">
    <div class="card">
        <div class="card-body">
            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('Bkash') }} </h4>
            </div>

            @if(hasPermission('payout_setup_settings_update'))

            <form action="{{route('payout.setup.settings.update',\App\Enums\PayoutSetup::BKASH)}}" method="POST" enctype="multipart/form-data" id="basicform">
                @method('PUT')
                @csrf
                @endif
                <div class="row">

                    <div class="form-group col-12">
                        <label class="label-style-1" for="bkash_app_id">{{ ___('label.bkash_app_id') }}<span class="text-danger">*</span> </label>
                        <input id="bkash_app_id" type="text" name="bkash_app_id" data-parsley-trigger="change" placeholder="{{ ___('label.bkash_app_id') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('bkash_app_id', settings('bkash_app_id')) }}" require>
                        @error('bkash_app_id')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label class="label-style-1" for="bkash_app_secret">{{ ___('label.bkash_app_secret') }}<span class="text-danger">*</span> </label>
                        <input id="bkash_app_secret" type="text" name="bkash_app_secret" data-parsley-trigger="change" placeholder="{{ ___('label.bkash_app_secret') }}" autocomplete="off" class="form-control input-style-1  " value="{{ old('bkash_app_secret', settings('bkash_app_secret')) }}" require>
                        @error('bkash_app_secret')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group col-12">
                        <label class="label-style-1" for="bkash_username">{{ ___('label.bkash_username') }}<span class="text-danger">*</span> </label>
                        <input id="bkash_username" type="text" name="bkash_username" data-parsley-trigger="change" placeholder="{{ ___('label.bkash_username') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('bkash_username', settings('bkash_username')) }}" require>
                        @error('bkash_username')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label class="label-style-1" for="bkash_password">{{ ___('label.bkash_password') }}<span class="text-danger">*</span> </label>
                        <input id="bkash_password" type="password" name="bkash_password" data-parsley-trigger="change" placeholder="{{ ___('label.bkash_password') }}" autocomplete="off" class="form-control input-style-1  " value="{{ old('bkash_password', settings('bkash_password')) }}" require>
                        @error('bkash_password')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="label-style-1" for="bkash_test_mode">{{ ___('label.test_mode') }}<span class="text-danger">*</span> </label>
                        <select name="bkash_test_mode" class="form-control input-style-1  select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('bkash_test_mode', settings('bkash_test_mode'))==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('bkash_test_mode') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="label-style-1" for="bkash_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                        <select name="bkash_status" class="form-control input-style-1  select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('bkash_status', settings('bkash_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('bkash_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    {{-- <div class="form-group col-12 d-flex">
                        <label class="label-style-1" for="switch-id">{{ ___('label.bkash_test_mode') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-id ml-3" name="bkash_test_mode" id="switch-id" type="checkbox" role="switch" @if(old('bkash_test_mode', settings('bkash_test_mode'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                    </div>
                </div>

                <div class="form-group col-12 d-flex">
                    <label class="label-style-1" for="switch-id">{{ ___('label.status') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-id ml-3" name="bkash_status" id="switch-id" type="checkbox" role="switch" @if(old('bkash_status', settings('bkash_status'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                    </div>
                </div> --}}

        </div>

        @if(hasPermission('payout_setup_settings_update'))
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

{{-- Stripe --}}
<div class="col-lg-6  col-md-6">
    <div class="card">
        <div class="card-body">

            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('Stripe') }} </h4>
            </div>

            @if(hasPermission('payout_setup_settings_update'))
            <form action="{{route('payout.setup.settings.update',\App\Enums\PayoutSetup::STRIPE)}}" method="POST" enctype="multipart/form-data" id="basicform">
                @method('PUT')
                @csrf
                @endif
                <div class="row">

                    <div class="form-group col-12">
                        <label class="label-style-1" for="stripe_publishable_key">{{ ___('label.stripe_publishable_key') }}<span class="text-danger">*</span> </label>
                        <input id="stripe_publishable_key" type="text" name="stripe_publishable_key" data-parsley-trigger="change" placeholder="{{ ___('label.stripe_publishable_key') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('stripe_publishable_key', settings('stripe_publishable_key')) }}" require>
                        @error('stripe_publishable_key')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-12">
                        <label class="label-style-1" for="stripe_secret_key">{{ ___('label.stripe_secret_key') }}<span class="text-danger">*</span> </label>
                        <input id="stripe_secret_key" type="text" name="stripe_secret_key" data-parsley-trigger="change" placeholder="{{ ___('label.stripe_secret_key') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('stripe_secret_key', settings('stripe_secret_key')) }}" require>
                        @error('stripe_secret_key')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-12">
                        <label class="label-style-1" for="stripe_status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                        <select name="stripe_status" class="form-control input-style-1  select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('stripe_status', settings('stripe_status'))==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('stripe_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    {{-- <div class="form-group col-12 d-flex">
                        <label class="label-style-1" for="switch-id">{{ ___('label.status') }}</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input switch-id ml-3" name="stripe_status" id="switch-id" type="checkbox" role="switch" @if(old('stripe_status', settings('stripe_status'))==\App\Enums\Status::ACTIVE) checked @else @endif>
                    </div>
                </div> --}}

        </div>

        @if(hasPermission('payout_setup_settings_update'))
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
