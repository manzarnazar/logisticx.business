@extends('backend.partials.master')
@section('title')
{{ ___('reports.leave_reports') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('leave.reports') }}" class="breadcrumb-link active">{{ ___('reports.leave_reports') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('reports.leave.reports')}}" method="GET">
                        {{-- @csrf --}}
                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }} <span class="text-danger">*</span></label>
                                <input type="date" placeholder="{{___('placeholder.enter_date_range')}}" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ old('date', request('date') ) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="user_id">{{ ___('label.user') }}</label>
                                <select multiple id="user_id" name="user_id[]" class="form-control  input-style-1 select2" data-url="{{ route('salary.users') }}" data-placeholder="{{ ___('placeholder.select_users') }}">
                                </select>
                                @error('user_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class=" label-style-1" for="department">{{ ___('label.department') }}</label>
                                <select class="form-control input-style-1 select2" id="department" name="department">
                                    <option></option>
                                    @foreach($departments as $department)
                                    <option {{$request->department == $department->id ? 'selected':''}} value="{{$department->id}}">{{$department->title}}</option>
                                    @endforeach
                                </select>
                                @error('department') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        <div class="form-row mt-2">
                            <div class=" col-md-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('leave.reports') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($leaves))
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site"> {{ ___('reports.leave_reports') }} </h4>
                    {{-- <a href="{{ route('download.all.leave.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn"> <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image"> <span>{{ ___('label.download_all') }}</span> </a> --}}

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            @php $i=1; @endphp

                            <thead class="bg">
                                <tr>
                                    <th scope="col">{{ ___('label.id') }}</th>
                                    <th scope="col">{{ ___('label.name') }}</th>
                                    <th scope="col">{{ ___('hr_manage.leave_type') }}</th>
                                    <th scope="col">{{ ___('label.date') }}</th>
                                    <th scope="col">{{ ___('hr_manage.days') }}</th>
                                    <th scope="col">{{ ___('hr_manage.available_days') }}</th>
                                    <th scope="col">{{ ___('hr_manage.total_leave') }}</th>
                                    <th scope="col">{{ ___('label.file') }}</th>
                                    <th scope="col">{{ ___('hr_manage.request_status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaves as $request )
                                <tr>
                                    <td>{{ $i++ }}</td>

                                    <td>{{ @$request->user->name}}</td>
                                    <td>{{ @$request->leaveTypes->name }}</td>
                                    <td>{{ dateFormat($request->from_date) }} - {{ dateFormat($request->to_date) }}</td>
                                    <td>{{ $request->days }}</td>
                                    <td>{{ @$request->AvailableDays }}</td>

                                    <td>

                                        @if ($request->total_leave)
                                        <ul>
                                            @foreach ($request->total_leave as $type => $days)
                                            <li>{{ ucfirst(str_replace('_', ' ', $type)) }}: {{ $days }} days</li>
                                            @endforeach
                                        </ul>
                                        @else
                                        <p>No total leave</p>
                                        @endif
                                    </td>

                                    <td>
                                        @if($request->file_id != null && $request->upload)
                                        <a class="bullet-badge-info p-2" href="{{ asset($request->upload->original) }}" download="{{ @$request->leaveTypes->name .'-'. $request->user->name }}"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download') }} </a>
                                        @endif
                                    </td>

                                    <td>{!! $request->LeaveRequestStatus !!}</td>


                                </tr>
                                @empty
                                <x-nodata-found :colspan="9" />
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection()

<!-- js  -->
@push('scripts')

<script src="{{ asset('backend/js/custom/reports/print.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/jquery.table2excel.min.js') }}"></script>
<script src="{{ asset('backend/js/custom/reports/reports.js') }}"></script>


@endpush
