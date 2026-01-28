@extends('backend.partials.master')
@section('title')
{{ ___('settings.sms_send_settings') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('sms-send-settings.index')}}" class="breadcrumb-link">{{ ___('settings.sms_send_settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('settings.sms_send_settings') }}</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name')}}</th>
                                    @if(hasPermission('sms_send_settings_status_change') == true)
                                    <th>{{ ___('label.status')}}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($smsSendSettings as $smsSendSetting)
                                <tr>
                                    <td>{{ $smsSendSetting->id }}</td>
                                    <td>{{ ___('settings.'. config('site.status.sms_send.'.$smsSendSetting->sms_send_status))}}</td>
                                    @if(hasPermission('sms_send_settings_status_change') == true)
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input switch-id" type="checkbox" data-url="{{ route('sms-send-settings.status') }}" data-id="{{ $smsSendSetting->id }}" role="switch" value="{{$smsSendSetting->status}}" @if($smsSendSetting->status== \App\Enums\Status::ACTIVE) checked @else @endif>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="3" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- pagination component -->
                @if(count($smsSendSettings))
                <x-paginate-show :items="$smsSendSettings" />
                @endif
                <!-- pagination component -->
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/smsSendSetting/smsSetting.js') }}"></script>
@endpush
