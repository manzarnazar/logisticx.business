@extends('backend.partials.master')
@section('title')
{{ ___('settings.sms_settings') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('sms-settings.index')}}" class="breadcrumb-link">{{ ___('settings.sms_settings') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('settings.sms_settings') }}
                </h4>
                @if (hasPermission('sms_settings_create'))
                <a href="{{ route('sms-settings.create') }}" class="j-td-btn">
                    <img src="{{asset('backend')}}/icons/icon/plus-white.png" class="jj" alt="no image">
                    <span>{{ ___('label.add') }}</span>
                </a>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('label.gateway')}}</th>
                                <th>{{ ___('label.apiKey')}}</th>
                                <th>{{ ___('label.secretKey')}}</th>
                                <th>{{ ___('label.status')}}</th>
                                @if(hasPermission('sms_settings_update') == true || hasPermission('sms_settings_delete') == true )
                                <th>{{ ___('label.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($smsSettings as $key => $smsSetting)
                            <tr id="row_{{ $smsSetting->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $smsSetting->gateway }}</td>
                                <td>{{ $smsSetting->api_key }}</td>
                                <td>{{ $smsSetting->secret_key }}</td>
                                <td>{!! $smsSetting->my_status !!}</td>

                                @if( hasPermission('sms_settings_update') == true || hasPermission('sms_settings_delete') == true )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if( hasPermission('sms_settings_update') == true )
                                        <a href="{{route('sms-settings.edit',$smsSetting->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if( hasPermission('sms_settings_delete') == true )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/module/blog/delete', {{$smsSetting->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <x-nodata-found :colspan="6" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- pagination component -->
                @if(count($smsSettings))
                <x-paginate-show :items="$smsSettings" />
                @endif
                <!-- pagination component -->
            </div>

        </div>
    </div>
</div>

@endsection()


@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
