@extends('backend.partials.master')
@section('title')
{{ ___('common.salary_generate') }} {{ ___('label.add') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('common.payroll')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('salary.index') }}" class="breadcrumb-link">{{ ___('common.salary_generate') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- basic form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.create') }} {{ ___('common.salary_generate') }} </h4>
                    </div>

                    <form action="{{route('salary.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6  ">
                                <label class="label-style-1" for="user_id">{{ ___('label.user') }} <span class="text-danger">*</span></label>
                                <select id="user_id" name="user_id" class="form-control input-style-1 select2" data-url="{{ route('salary.users') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('label.title') }}</option>
                                </select>
                                @error('user_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="month">{{ ___('common.month')}}<span class="text-danger">*</span> </label>
                                <input type="month" id="month" name="month" placeholder="yyyy-mm" class="form-control input-style-1" value="{{old('month',date('Y-m'))}}" required>
                                @error('month') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="basic_salary">{{ ___('label.basic_salary')}}<span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="basic_salary" id="basic_salary" class="form-control input-style-1" value="{{ old('basic_salary') }}" data-url="{{ route('salary.getBasicSalary') }}" placeholder="{{ ___('placeholder.basic_salary') }}" @disabled(true)>
                                @error('basic_salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6 mb-md-0">
                                <label class="label-style-1" for="note">{{ ___('label.note')}}</label>
                                <textarea class="form-control input-style-1" name="note" placeholder="{{ ___('placeholder.note')}}">{{ old('note') }}</textarea>
                            </div>

                            <div class="col-md-6 form-group mb-md-0 mb-md-0">
                                <label class="label-style-1">{{ ___('label.allowances')}}</label>
                                <div id="allowance-container">
                                    <div class="row">
                                        <div class="col-md-7 mb-3 mb-md-0">
                                            <input type="text" name="allowance[1][name]" class="form-control input-style-1" placeholder="Enter allowance name">
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="allowance[1][amount]" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addAllowance()"> <i class="fa fa-plus"></i> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group mb-md-0">
                                <label class="label-style-1">{{ ___('label.deductions')}}</label>
                                <div id="deduction-container">
                                    <div class="row">
                                        <div class="col-md-7 mb-3 mb-md-0">
                                            <input type="text" name="deduction[1][name]" class="form-control input-style-1" placeholder="Enter deduction name">
                                        </div>
                                        <div class="col-md-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="deduction[1][amount]" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addDeduction()"> <i class="fa fa-plus"></i> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.save') }}</button>
                                <a href="{{ route('salary.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "> </i> {{ ___('label.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/salarygenerate/custom.js') }}"></script>
@endpush
