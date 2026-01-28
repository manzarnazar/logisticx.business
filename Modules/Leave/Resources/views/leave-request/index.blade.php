@extends('backend.partials.master')
@section('title',___('hr_manage.leave_request') )
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.leave_request') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pigheaded -->

    <div class="j-parcel-main j-parcel-res">
        <div class="card">

            {{-- FAQ Header Title --}}
            <div class="card-header mb-3">
                <h4 class="title-site">{{ ___('hr_manage.my_leave_request') }} {{ ___('label.list') }}</h4>
                @if (hasPermission('leave_request_create'))
                <a href="{{ route('leave-request.create') }}" class="j-td-btn"> <img src="{{asset('backend/icons/icon/plus-white.png')}}" class="jj" alt="no image"> <span>{{ ___('label.add') }}</span> </a>
                @endif
            </div>



            {{-- FAQ Index Body --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg">
                            <tr>
                                <th scope="col">{{ ___('label.id') }}</th>
                                <th scope="col">{{ ___('label.name') }}</th>
                                <th scope="col">{{ ___('hr_manage.leave_type') }}</th>
                                <th scope="col">{{ ___('label.from') }}</th>
                                <th scope="col">{{ ___('label.to') }}</th>
                                <th scope="col">{{ ___('label.days') }}</th>
                                <th scope="col">{{ ___('label.attachment') }}</th>
                                <th scope="col">{{ ___('label.status') }}</th>

                                @if(hasPermission('leave_request_update') || hasPermission('leave_request_delete'))
                                <th scope="col">{{ ___('label.action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leave_requests as $key=>$request )

                            <tr id="row_{{ $request->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ @$request->user->name}}</td>
                                <td>{{ @$request->leaveTypes->name }}</td>
                                <td>{{ dateFormat($request->from_date) }} </td>
                                <td>{{ dateFormat($request->to_date) }}</td>
                                <td>{{ $request->days . ' ' . ___('label.days') }}</td>

                                <td>
                                    @if($request->file_id != null && $request->upload)
                                    <a class="bullet-badge-info p-2" href="{{ asset($request->upload->original) }}" download="{{ @$request->leaveTypes->name .'-'. $request->user->name }}"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download') }} </a>
                                    @endif
                                </td>

                                <td>{!! $request->LeaveRequestStatus !!}</td>

                                @if(hasPermission('leave_request_update') || hasPermission('leave_request_delete'))
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if(hasPermission('leave_request_update'))
                                        <a href="{{ route('leave-request.edit',$request->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if(hasPermission('leave_request_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/leave-management/leave-request/delete', {{$request->id}})">
                                            <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                        </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="10" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- pagination component -->
                @if(count($leave_requests))
                <x-paginate-show :items="$leave_requests" />
                @endif

            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
