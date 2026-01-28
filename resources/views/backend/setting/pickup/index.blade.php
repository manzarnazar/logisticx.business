@extends('backend.partials.master')
@section('title')
{{ ___('menus.pickup_slot') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('pickup.index') }}" class="breadcrumb-link">{{ ___('menus.pickup_slot') }}</a></li>
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
                    <h4 class="title-site">{{ ___('menus.pickup_slot') }} </h4>
                    @if(hasPermission('pickup_create') )
                    <a href="{{route('pickup.create')}}" class="j-td-btn">
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
                                    <th>{{ ___('label.title') }}</th>
                                    <th>{{ ___('label.start_time') }}</th>
                                    <th>{{ ___('label.end_time') }}</th>
                                    <th>{{ ___('label.position') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if(hasPermission('pickup_update') == true || hasPermission('pickup_delete') == true)
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($pickups as $pickup)
                                <tr id="row_{{ $pickup->id }}">
                                    <td>{{$i++}}</td>
                                    <td>{{$pickup->title}}</td>
                                    <td>{{ dateTimeFormat($pickup->start_time) }}</td>
                                    <td>{{ dateTimeFormat($pickup->end_time) }}</td>
                                    <td>{{$pickup->position}}</td>
                                    <td>{!! $pickup->my_status !!}</td>
                                    @if(hasPermission('pickup_update') == true || hasPermission('pickup_delete') == true)
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('pickup_update') == true )
                                            <a href="{{route('pickup.edit',$pickup->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if(hasPermission('pickup_delete') == true)
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/settings/pickup-slot/delete', {{$pickup->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($pickups))
                    <x-paginate-show :items="$pickups" />
                    @endif
                    <!-- pagination component -->
                </div>

                </div>
            </div>
            <!-- end data table  -->
        </div>
    </div>
    <!-- end wrapper  -->
    @endsection()
    @push('scripts')
    @include('backend.partials.delete-ajax')
    @endpush
