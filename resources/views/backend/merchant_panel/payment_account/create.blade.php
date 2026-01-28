@extends('backend.partials.master')
@section('title')
{{ ___('merchant.payment_accounts') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('menus.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('merchant.payment_accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('merchant.create') }}</a></li>
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
                <div class="form-input-header">
                    <h4 class="title-site">{{ ___('merchant.create_account') }} </h4>
                </div>

                <div class="card-body">

                    <form action="{{route('merchant.payment.account.store')}}" method="POST">
                        @csrf

                        {{-- <input id="merchant_id" type="hidden" name="merchant_id" value="{{ auth()->user()->merchant->id }}" /> --}}

                        <div class="form-row">

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="payment_method">{{ ___('merchant.payment_method') }}</label> <span class="text-danger"></span>
                                <select name="payment_method" id="payment_method" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach (config('merchantpayment.payment_method') as $value)
                                    <option value="{{ $value }}" @selected(old('payment_method')==$value)>{{ ___('merchant.'.$value) }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 bank-input d-none ">
                                <label class="label-style-1" for="bank_id">{{ ___('merchant.select_bank') }}<span class="text-danger">*</span> </label>
                                <select id="bank_id" name="bank_id" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach (@$banks as $bank)
                                    <option value="{{ @$bank->id }}" @selected(old('bank_id')==$bank->id)>{{ @$bank->bank_name  }}</option>
                                    @endforeach
                                </select>
                                @error('bank_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 bank-input d-none ">
                                <label class="label-style-1" for="branch_name">{{ ___('merchant.branch_name') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="branch_name" id="branch_name" class="form-control input-style-1" value="{{old('branch_name')}}" placeholder="{{ ___('placeholder.enter_branch_name') }}">
                                @error('branch_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 bank-input d-none ">
                                <label class="label-style-1" for="routing_no">{{ ___('account.routing_number') }}.<span class="text-danger">*</span> </label>
                                <input id="routing_no" type="number" name="routing_no" placeholder="{{ ___('placeholder.routing_number') }}" class="form-control input-style-1" value="{{old('routing_no')}}">
                                @error('routing_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 mfs-input d-none">
                                <label class="label-style-1" for="mfs">{{ ___('merchant.mfs') }}<span class="text-danger">*</span> </label>
                                <select id="mfs" name="mfs" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach (config('merchantpayment.mfs_providers') as $value)
                                    <option value="{{ $value }}" @selected( old('mfs')==$value)>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('mfs') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 common-input d-none">
                                <label class="label-style-1" for="account_name">{{ ___('merchant.account_name') }}<span class="text-danger">*</span> </label>
                                <input id="account_name" type="text" name="account_name" placeholder="{{ ___('merchant.account_name') }}" class="form-control input-style-1" value="{{old('account_name')}}">
                                @error('account_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 bank-input d-none ">
                                <label class="label-style-1" for="account_no">{{ ___('merchant.account_no') }}.<span class="text-danger">*</span> </label>
                                <input id="account_no" type="number" name="account_no" placeholder="{{ ___('merchant.account_no') }}" class="form-control input-style-1" value="{{old('account_no')}}">
                                @error('account_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6 common-input d-none ">
                                <label class="label-style-1" for="mobile_no">{{ ___('merchant.mobile_no') }}<span class="text-danger">*</span> </label>
                                <input id="mobile_no" type="tel" name="mobile_no" placeholder="{{ ___('placeholder.mobile_number') }}" class="form-control input-style-1" value="{{old('mobile_no')}}">
                                @error('mobile_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- Bank Account type --}}
                            <div class="form-group col-12 col-md-6 bank-input d-none">
                                <label class="label-style-1" for="bank_account_type">{{ ___('account.account_type') }}<span class="text-danger">*</span> </label>
                                <select id="bank_account_type" name="bank_account_type" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach (config('merchantpayment.account_types.bank') as $value)
                                    <option value="{{ $value }}" @selected(old('bank_account_type')==$value)> {{ $value }} </option>
                                    @endforeach
                                </select>
                                @error('bank_account_type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- MFS Account type --}}
                            <div class="form-group col-12 col-md-6 mfs-input d-none">
                                <label class="label-style-1" for="mfs_account_type">{{ ___('account.account_type') }}<span class="text-danger">*</span> </label>
                                <select id="mfs_account_type" name="mfs_account_type" class="form-control input-style-1 select2">
                                    <option></option>
                                    @foreach (config('merchantpayment.account_types.mfs') as $value)
                                    <option value="{{ $value }}" @selected(old('mfs_account_type')==$value)> {{ $value }} </option>
                                    @endforeach
                                </select>
                                @error('mfs_account_type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="status">{{ ___('label.status')}}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('merchant.payment.account.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/merchant/account_curd.js') }}"></script>
@endpush
