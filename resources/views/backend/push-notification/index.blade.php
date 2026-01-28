@extends('backend.partials.master')
@section('title')
{{ ___('common.title') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('push-notification.index')}}" class="breadcrumb-link">{{ ___('common.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('common.title') }} </h4>
                    @if(hasPermission('push_notification_create') )
                    <a href="{{route('push-notification.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.image') }}</th>
                                    <th>{{ ___('label.title') }}</th>
                                    <th>{{ ___('label.description') }}</th>
                                    <th>{{ ___('label.type') }}</th>
                                    <th>{{ ___('label.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=1;
                                @endphp
                                @forelse($pushNotifications as $pushNotification)
                                <tr id="row_{{ $pushNotification->id }}">
                                    <td>{{$i++}}</td>
                                    <td>
                                        <img src="{{ $pushNotification->image }}" alt="Image" width="45" height="65">
                                    </td>
                                    <td>{{ Str::limit(strip_tags($pushNotification->title), 50) }}</td>
                                    <td>{{ Str::limit(strip_tags($pushNotification->description), 50) }}</td>
                                    <td>{!! $pushNotification->notification_type !!}</td>
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if( hasPermission('push_notification_delete') == true)
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/push-notification/delete', {{$pushNotification->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>

                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($pushNotifications))
                <x-paginate-show :items="$pushNotifications" />
                @endif
                <!-- pagination component -->
            </div>
        </div>
        <!-- end table  -->
    </div>
</div>
@endsection()
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
