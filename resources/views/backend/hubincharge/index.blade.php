@extends('backend.partials.master')
@section('title')
{{ ___('hub.incharge') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('hubs.index') }}" class="breadcrumb-link">{{ ___('hub.hubs') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('hub-incharge.index', $hub->id) }}" class="breadcrumb-link">{{ ___('hub.incharge') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('hub.incharge') }} {{ ___('label.list') }}</a></li>
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
                    <h4 class="title-site">{{ $hub->name . ' ' . ___('hub.incharge') }}</h4>
                    @if (hasPermission('hub_incharge_create') == true)
                    <a href="{{ route('hub-incharge.create', $hub->id) }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.user') }}</th>
                                    <th>{{ ___('label.phone') }}</th>
                                    <th>{{ ___('label.assigned_date') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if (hasPermission('hub_incharge_update') == true || hasPermission('hub_incharge_delete') == true)
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hubInCharges as $key => $incharge)
                                <tr id="row_{{ $incharge->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="pr-3">
                                                <img src="{{ getImage($incharge->user->upload, 'original','default-image-40x40.png') }}" alt="user" class="rounded" width="40" height="40">
                                            </div>
                                            <div>
                                                <strong>{{ $incharge->user->name }}</strong>
                                                <p>{{ $incharge->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $incharge->user->mobile }}</td>
                                    <td>{{ date('d M Y', strtotime($incharge->updated_at)) }}</td>
                                    <td>{!! $incharge->my_status !!}</td>
                                    @if (hasPermission('hub_incharge_update') == true || hasPermission('hub_incharge_delete') == true)
                                    <td>

                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>

                                        <div class="dropdown-menu">

                                            @if (hasPermission('hub_incharge_update') == true)
                                            <a href="{{ route('hub-incharge.edit', [$hub->id, $incharge]) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if (hasPermission('hub_incharge_delete') == true)
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('hub/incharge/{{ $hub->id }}/delete',{{ $incharge->id }})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif

                                            @if (hasPermission('hub_incharge_assigned') == true)
                                            <a href="{{ route('hub-incharge.assigned', [$hub->id, $incharge]) }}" class="dropdown-item"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ ___('hub.assigned') }}</a>
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
