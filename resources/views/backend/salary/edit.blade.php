@extends('backend.partials.master')
@section('title')
{{ ___('common.salary_generate') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('common.salary_generate') }} </h4>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif



                    <form action="{{route('salary.update')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('put')

                        <input type="hidden" name="id" value="{{ $salary->id }}">

                        {{-- <input type="hidden" name="user_id" id="{{ $salary->user_id }}"> --}}

                        <div class="form-row">

                            <div class="form-group col-md-6  ">
                                <label class="label-style-1" for="user_id">{{ ___('label.user') }} </label>
                                <input type="text" class="form-control input-style-1" value="{{ $salary->user->name}}" readonly disabled>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('common.month')}}<span class="text-danger">*</span> </label>
                                <input type="month" id="month" name="month" placeholder="Month, yyyy" class="form-control input-style-1" value="{{old('date',date( $salary->month ))}}" required>
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="basic_salary">{{ ___('label.basic_salary')}}<span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="basic_salary" id="basic_salary" class="form-control input-style-1" value="{{ old('basic_salary',$salary->amount) }}" data-url="{{ route('salary.getBasicSalary') }}" placeholder="{{ ___('placeholder.basic_salary') }}" @disabled(true)>
                                @error('basic_salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="note">{{ ___('label.note')}}</label>
                                <textarea class="form-control input-style-1" name="note" placeholder="{{ ___('placeholder.note')}}"> {{ old('note',$salary->note) }} </textarea>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="label-style-1">{{ ___('label.allowances')}}</label>
                                <div id="allowance-container">

                                    @forelse ($salary->allowance as $key => $allowance )

                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="allowance[{{ $key }}][name]" value="{{ $allowance['name'] }}" class="form-control input-style-1" placeholder="Enter allowance name">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="allowance[{{ $key }}][amount]" value="{{ $allowance['amount'] }}" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                @if ($loop->first)
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addAllowance()"> <i class="fa fa-plus"></i> </span>
                                                @else
                                                <span class="input-group-text btn btn-danger ml-1 p-0" onclick="deleteRow(this)"> <i class="fa-solid fa-trash"></i> </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @empty

                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="allowance[1][name]" class="form-control input-style-1" placeholder="Enter allowance name">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="allowance[1][amount]" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addAllowance()"> <i class="fa fa-plus"></i> </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse

                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="label-style-1">{{ ___('label.deductions')}}</label>
                                <div id="deduction-container">

                                    @forelse ($salary->deduction as $key => $deduction )
                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="deduction[{{ $key }}][name]" value="{{ $deduction['name'] }}" class="form-control input-style-1" placeholder="Enter deduction name">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="deduction[{{ $key }}][amount]" value="{{ $deduction['amount'] }}" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                @if ($loop->first)
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addDeduction()"> <i class="fa fa-plus"></i> </span>
                                                @else
                                                <span class="input-group-text btn btn-danger ml-1 p-0" onclick="deleteRow(this)"> <i class="fa-solid fa-trash"></i> </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @empty

                                    <div class="row">
                                        <div class="col-7">
                                            <input type="text" name="deduction[1][name]" class="form-control input-style-1" placeholder="Enter deduction name">
                                        </div>
                                        <div class="col-5">
                                            <div class="input-group mb-3">
                                                <input type="number" step="any" name="deduction[1][amount]" class="form-control input-style-1" placeholder="{{ ___('placeholder.amount') }}">
                                                <span class="input-group-text btn btn-info ml-1 p-0" onclick="addDeduction()"> <i class="fa fa-plus"></i> </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforelse

                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('salary.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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

</script> --}}
<script src="{{ asset('backend/js/custom/salarygenerate/custom.js') }}"></script>
@endpush
