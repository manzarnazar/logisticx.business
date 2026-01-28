@extends('backend.partials.master')
@section('title')
{{ ___('menus.fraud_list') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('menus.fraud') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('menus.fraud_list') }}</h4>
                    @if(hasPermission('fraud_create') == true)
                    <a href="{{route('fraud.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.phone') }}</th>
                                    <th>{{ ___('label.name') }}</th>
                                    <th>{{ ___('label.details') }}</th>
                                    <th>{{ ___('label.track_id') }}</th>
                                    @if(hasPermission('fraud_update') == true || hasPermission('fraud_delete') == true )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($frauds as $key => $fraud)
                                <tr id="row_{{ $fraud->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{$fraud->phone}}</td>
                                    <td>{{$fraud->name}}</td>
                                    <td>{{$fraud->details}}</td>
                                    <td>{{$fraud->tracking_id}}</td>
                                    @if(hasPermission('fraud_update') == true || hasPermission('fraud_delete') == true )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('fraud_update') == true )
                                            <a href="{{route('fraud.edit',$fraud->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if(hasPermission('fraud_delete') == true )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/fraud/delete', {{$fraud->id}})">
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
                    @if(count($frauds))
                    <x-paginate-show :items="$frauds" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
