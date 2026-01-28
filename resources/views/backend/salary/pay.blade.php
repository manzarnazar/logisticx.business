@extends('backend.partials.master')
@section('title')
{{ ___('common.salary') }} {{ ___('label.pay') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('common.payroll')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('salary.index') }}" class="breadcrumb-link">{{ ___('common.salary') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.pay') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-md-6">

            <div class="j-create-main">

                <div class="form-input-header">
                    <h4 class="title-site"> {{ ___('label.pay_salary') }}
                    </h4>
                </div>

                <form action="{{route('salary.pay.process')}}" method="POST">
                    @csrf

                    <input type="hidden" name="salary_generate_id" value="{{ $salary->id }}">


                    <div class="form-group w-100">
                        <label class="label-style-1" for="account_id">{{ ___('label.from_account')}}<span class="text-danger">*</span> </label>
                        <select id="account_id" name="account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.search') }}" required data-placeholder="{{ ___('placeholder.select_account') }}">
                            <option value=""></option>
                        </select>
                        @error('account_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label class="label-style-1" for="note">{{ ___('label.note')}}</label>
                        <textarea class="form-control input-style-1" placeholder="{{ ___('placeholder.enter_description') }}" name="note" rows="5">{{ old('note') }}</textarea>
                        @error('note') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="j-create-btns mt-4">
                        <div class="drp-btns">
                            <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                            <a href="{{ route('salary.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-md-6">
            <div class="j-eml-card">
                <h5 class="heading-5">Salary Details </h5>
                <ul class="j-eml-list">
                    <li>
                        <h6 class="heading-6">{{ ___('label.user') }}</h6>
                        <span>{{@$salary->user->name}}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.month') }}</h6>
                        <span>{{ \Carbon\Carbon::parse($salary->month)->format('F Y') }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.salary') }}</h6>
                        <span>{{ @$salary->amount }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.allowances') }}</h6>
                        <span>{{ @$salary->totalAllowance }}</span>
                    </li>
                    <li>
                        <h6 class="heading-6">{{ ___('label.deductions') }}</h6>
                        <span>{{ @$salary->totalDeduction }}</span>
                    </li>

                    <li>
                        <h6 class="heading-6">{{ ___('label.net_salary') }}</h6>
                        <span>{{ @$salary->netSalary }}</span>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection()


@push('scripts')

{{-- this script used for searchAccount(); --}}
<script src="{{ asset('backend/js/custom/salarygenerate/custom.js') }}"></script>

@endpush
