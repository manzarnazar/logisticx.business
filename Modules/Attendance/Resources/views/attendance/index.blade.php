@extends('backend.partials.master')
@section('title',___('hr_manage.attendance') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.attendance_management') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.attendance') }}</a></li>
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

            {{-- FAQ Header Title --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('hr_manage.attendance') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('attendance_create'))
                <a href="{{ route('attendance.create') }}" class="j-td-btn"> <img src="{{asset('backend/icons/icon/plus-white.png')}}" class="jj" alt="no image"> <span>{{ ___('label.add') }}</span> </a>
                @endif
            </div>

            {{-- FAQ Index Body --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ ___('label.name') }}</th>
                                <th scope="col">{{ ___('label.department') }}</th>
                                <th scope="col">{{ ___('label.designation') }}</th>
                                <th scope="col">{{ ___('label.date') }}</th>
                                <th scope="col">{{ ___('hr_manage.check_in') }}</th>
                                <th scope="col">{{ ___('hr_manage.check_out') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if(hasPermission('attendance_update') || hasPermission('attendance_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($attendances as $key=>$attendance )

                            <tr id="row_{{ $attendance->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ @$attendance->user->name }}</td>
                                <td>{{ @$attendance->user->department->title }}</td>
                                <td>{{ @$attendance->user->designation->title }}</td>
                                <td>{{ dateFormat(@$attendance->date) }}</td>
                                <td>{{ $attendance->check_in ? timeFormat($attendance->check_in) : '' }} </td>
                                <td>{{ $attendance->check_out ? timeFormat($attendance->check_out) : '' }} </td>
                                <td>{!! $attendance->attendance_type !!}</td>

                                @if(hasPermission('attendance_update') || hasPermission('attendance_delete'))
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">

                                        @if(hasPermission('attendance_update'))
                                        <a href="{{ route('attendance.edit',$attendance->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif

                                        @if(hasPermission('attendance_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/attendance/delete', {{$attendance->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                        @endif

                                    </div>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="9" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- pagination component -->
                @if(count($attendances))
                <x-paginate-show :items="$attendances" />
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
