@extends('backend.partials.master')
@section('title')
{{ ___('reports.attendance_reports') }}
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
                            <li class="breadcrumb-item"><a href="{{route('attendance.reports') }}" class="breadcrumb-link active">{{ ___('reports.attendance_reports') }}</a></li>

                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            {{-- filter/search form card --}}
            <div class="card">
                <div class="card-body">
                    <form action="{{route('reports.attendance.reports')}}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }} <span class="text-danger">*</span></label>
                                <input type="date" autocomplete="off" placeholder="{{___('placeholder.enter_date_range')}}" id="date" name="date" class="form-control  input-style-1  flatpickr-range" value="{{ old('date',$request->date) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- id="user_id" --}}
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="user_id">{{ ___('label.user') }}</label>
                                <select multiple id="user_id" name="user_id[]" class="form-control input-style-1 select2" data-url="{{ route('salary.users') }}" data-placeholder="{{ ___('placeholder.select_users') }}">
                                    {{-- <option value=""> {{ ___('Select User') }}</option> --}}

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
                            <div class="col-md-4">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('attendance.reports') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



            @if(isset($attendances))

            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('reports.attendance_reports') }} </h4>
                    {{-- <a href="{{ route('download.all.attendance.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn"> <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image"> <span>{{ ___('label.download_all') }}</span> </a> --}}

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">

                            <thead class="bg">
                                <tr>
                                    <th scope="col">{{ ___('label.id') }}</th>
                                    <th scope="col">{{ ___('label.name') }}</th>
                                    <th scope="col">{{ ___('label.date') }}</th>
                                    <th scope="col">{{ ___('hr_manage.check_in') }}</th>
                                    <th scope="col">{{ ___('hr_manage.check_out') }}</th>
                                    <th scope="col">{{ ___('label.department') }}</th>
                                    <th scope="col">{{ ___('label.designation') }}</th>
                                    <th scope="col">{{ ___('label.status') }}</th>
                            </thead>
                            <tbody>

                                @php $i=1; @endphp

                                @forelse ($attendances as $attendance )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ @$attendance->user->name }}</td>
                                    <td>{{ dateFormat(@$attendance->date) }}</td>
                                    <td>{{ $attendance->check_in ? date('h:i:s A', strtotime($attendance->check_in)) : '' }} </td>
                                    <td>{{ $attendance->check_out ? date('h:i:s A', strtotime($attendance->check_out)) : '' }} </td>
                                    <td>{{ @$attendance->user->department->title }}</td>
                                    <td>{{ @$attendance->user->designation->title }}</td>
                                    <td>{!! $attendance->attendance_type !!}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="8" />
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
