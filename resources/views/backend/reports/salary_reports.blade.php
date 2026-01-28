@extends('backend.partials.master')
@section('title')
{{ ___('reports.salary_reports') }}
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
                            <li class="breadcrumb-item"><a href="{{route('salary.reports') }}" class="breadcrumb-link active">{{ ___('reports.salary_reports') }}</a></li>

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
                    <form action="{{route('reports.salary.reports')}}" method="GET">
                        {{-- @csrf --}}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="date">{{ ___('common.month')}}<span class="text-danger">*</span> </label>
                                <input type="month" id="month" data-toggle="month" name="month" placeholder="yyyy-mm-dd" class="form-control  input-style-1" value="{{old('date',isset($request->month) ? $request->month:date('Y-m'))}}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- id="user_id" --}}
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="user_id">{{ ___('label.user') }}</label>

                                <select multiple id="user_id" name="user_id[]" class="form-control  input-style-1 select2" data-url="{{ route('salary.users') }}" data-placeholder="{{ ___('placeholder.select_users') }}">
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
                                    <a href="{{ route('salary.reports') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(isset($salaries))
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('reports.salary_reports') }} </h4>

                    <a href="{{ route('download.all.salary.reports', ['filtered_ids' => implode(',', $filteredIds)]) }}" class="j-td-btn"> <img src="{{ asset('backend/icons/icon/download-white-5.png') }}" class="jj" alt="no image"> <span>{{ ___('label.download_all') }}</span> </a>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            @php $i=1; @endphp

                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.user') }}</th>
                                    <th>{{ ___('label.department') }}</th>
                                    <th>{{ ___('label.month') }}</th>
                                    <th>{{ ___('reports.salary') }}</th>
                                    <th>{{ ___('reports.paid_amount') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($salaries as $key=>$salary )
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        <span class="d-block"> {{@$salary->user->name}}</span>
                                        <span class="d-block"> {{@$salary->user->email}}</span>
                                    </td>
                                    <td>{{ @$salary->user->department->title }}</td>
                                    <td>{{\Carbon\Carbon::createFromFormat('Y-m',@$salary->month)->format('M Y')}}</td>
                                    <td> {{ settings('currency') }}{{ @$salary->amount}}</td>

                                    <td>
                                        @if ($salary->paidSalary && $salary->paidSalary->isNotEmpty())
                                        {{ $salary->paidSalary->first()->amount }}
                                        @else
                                        {{ ___('label.not_paid_yet') }}
                                        @endif
                                    </td>

                                    <td> {!! $salary->MyStatus !!} </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
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
