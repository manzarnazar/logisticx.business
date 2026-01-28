@extends('backend.partials.master')

@section('title')
{{ ___('menus.mail_setting') }}
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
                            <li class="breadcrumb-item"><a href="{{route('settings.mail.index')}}" class="breadcrumb-link active">{{ ___('menus.mail_setting') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">

            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('menus.mail_setting') }} </h4>
            </div>

            <form action="{{route('settings.update')}}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="mail_driver">{{ ___('label.mail_driver') }}<span class="text-danger">*</span> </label>
                        <select name="mail_driver" class="form-control select2" id="mail_driver" @if(!hasPermission('mail_settings_update')) disabled @endif>
                            {{-- <option value="sendmail" {{ old('mail_driver',settings('mail_driver')) == 'sendmail'? 'selected':'' }}>{{ ___('sendmail') }}</option> --}}
                            <option value="smtp" {{ old('mail_driver',settings('mail_driver')) == 'smtp'? 'selected':'' }}>{{ ___('smtp') }}</option>
                        </select>
                        @error('mail_driver') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 sendmail">
                        <label class="label-style-1" for="sendmail_path">{{ ___('label.path') }}<span class="text-danger">*</span> </label>
                        <input type="text" name="sendmail_path" id="sendmail_path" class="form-control input-style-1 " value="{{ old('sendmail_path', settings('sendmail_path')) }}" placeholder="{{ ___('placeholder.enter_sendmail_path') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('sendmail_path') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_host">{{ ___('label.mail_host') }}<span class="text-danger">*</span> </label>
                        <input type="text" name="mail_host" id="mail_host" class="form-control input-style-1 " value="{{ old('mail_host', settings('mail_host')) }}" placeholder="{{ ___('placeholder.enter_mail_host') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('mail_host') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_port">{{ ___('label.mail_port') }}<span class="text-danger">*</span> </label>
                        <input type="text" name="mail_port" id="mail_port" class="form-control input-style-1 " value="{{ old('mail_port', settings('mail_port')) }}" placeholder="{{ ___('placeholder.enter_mail_port') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('mail_port') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_address">{{ ___('label.mail_address') }}<span class="text-danger">*</span> </label>
                        <input type="email" name="mail_address" id="mail_address" class="form-control input-style-1 " value="{{ old('mail_address', settings('mail_address')) }}" placeholder="{{ ___('placeholder.email') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('mail_address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_name">{{ ___('label.mail_name') }}</label>
                        <input type="text" name="mail_name" id="mail_name" placeholder="{{ ___('placeholder.enter_mail_name') }}" class="form-control input-style-1 " value="{{ old('mail_name',settings('mail_name')) }}" @if(!hasPermission('mail_settings_update')) disabled @endif>
                        @error('mail_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_username">{{ ___('label.mail_username') }}<span class="text-danger">*</span> </label>
                        <input type="text" name="mail_username" id="mail_username" class="form-control input-style-1 " value="{{ old('mail_username', settings('mail_username')) }}" placeholder="{{ ___('placeholder.enter_mail_username') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('mail_username') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_password">{{ ___('label.mail_password') }}<span class="text-danger">*</span> </label>
                        <input type="password" name="mail_password" id="mail_password" class="form-control input-style-1 " value="{{ old('mail_password', decrypt(settings('mail_password'))) }}" placeholder="{{ ___('placeholder.enter_mail_password') }}" @disabled(!hasPermission('mail_settings_update')) />
                        @error('mail_password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="mail_encryption">{{ ___('label.mail_encryption') }}<span class="text-danger">*</span> </label>
                        <select name="mail_encryption" class="form-control  select2" id="mail_encryption" @if(!hasPermission('mail_settings_update')) disabled @endif>
                            <option value="">Null</option>
                            <option @if(settings('mail_encryption')=='tls' ) selected @endif value="tls">{{ ___('label.tls')}} </option>
                            <option @if(settings('mail_encryption')=='ssl' ) selected @endif value="ssl">{{ ___('label.ssl')}} </option>
                        </select>
                        @error('mail_encryption') <small class="text-danger mt-2">{{ $message }}</small> @enderror

                    </div>

                    <div class="form-group col-12 col-md-6 smtp">
                        <label class="label-style-1" for="signature">{{ ___('label.signature') }}<span class="text-danger">*</span> </label>
                        <textarea name="signature" id="signature" class="form-control input-style-1" placeholder="{{ ___('placeholder.enter_signature') }}" @disabled(!hasPermission('mail_settings_update'))>{{ old('signature', settings('signature')) }}</textarea>
                        @error('signature') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>
                @if(hasPermission('mail_settings_update'))

                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i> {{ ___('label.save_change') }}</button>
                    </div>
                </div>

                @endif
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(hasPermission('mail_settings_read'))
            <form action="{{ route('settings.testSendMail') }}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6 col-sm-10">
                        <label class="label-style-1">{{ ___('label.email') }} <span class="text-danger">*</span></label>
                        <input type="email" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1" value="{{ old('email') }}">
                        @error('email') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                    </div>

                </div>
                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn">{{ ___('label.test') }}</button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>



</div>
@endsection()

@push('scripts')
<script src="{{asset('backend/js/custom/settings/mail-settings.js')}}"></script>
@endpush
