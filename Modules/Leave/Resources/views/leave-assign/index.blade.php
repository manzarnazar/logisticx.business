@extends('backend.partials.master')
@section('title',___('hr_manage.leave_assign') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.leave_management') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.leave_assign') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('hr_manage.leave_assign') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('leave_assign_create'))
                <a href="{{ route('leave.assign.create') }}" class="j-td-btn">
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
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.department') }}</th>
                                <th scope="col">{{ ___('hr_manage.leave_type') }}</th>
                                <th scope="col">{{ ___('hr_manage.days') }}</th>
                                <th scope="col">{{ ___('label.position') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if(hasPermission('leave_assign_update') || hasPermission('leave_assign_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leave_assigns as $key=>$assign )

                            <tr id="row_{{ $assign->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ @$assign->department->title }}</td>
                                <td>{{ @$assign->type->name }}</td>
                                <td>{{ $assign->days }}</td>
                                <td>{{ $assign->position }}</td>
                                <td>{!! $assign->my_status !!}</td>

                                @if(hasPermission('leave_assign_update') || hasPermission('leave_assign_delete'))
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('leave_assign_update'))
                                        <a href="{{ route('leave.assign.edit',$assign->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if(hasPermission('leave_assign_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/leave/assign/delete', {{$assign->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                @if(count($leave_assigns))
                <x-paginate-show :items="$leave_assigns" />
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
