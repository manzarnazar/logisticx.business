@extends('backend.partials.master')
@section('title')
{{ ___('hub.title') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('hub.hub-payment.index') }}" class="breadcrumb-link">{{ ___('label.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="card">
        <div class="card-body">

            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('hub.create_payment') }}</h4>
            </div>

            <form action="{{route('hub.hub-payment.store')}}" method="POST" enctype="multipart/form-data" id="hubPaymentForm">
                @csrf
                <div class="form-row">
                    <div class="col-lg-6 col-12 form-group">
                        <label class="label-style-1" for="hub_id">{{ ___('label.title') }}<span class="text-danger">*</span> </label>
                        <select id="hub_id" class="form-control input-style-1 select2" name="hub_id">
                            <option selected disabled>{{ ___('menus.select') }} {{ ___('hub.title') }}</option>
                            @foreach ($hubs as $hub)
                            <option value="{{ $hub->id }}" @selected(old('hub_id'))>{{ $hub->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_id"></small>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="hub_account_id">{{ ___('label.hub_account') }} <span class="text-danger">*</span> </label>
                        <select id="hub_account_id" name="hub_account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.searchByHub') }}">
                            <option selected disabled>{{ ___('menus.select') }} {{ ___('label.hub_account') }} </option>
                        </select>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_account_id"></small>
                    </div>

                    <div class="col-lg-6 col-12 form-group">
                        <label class="label-style-1" for="amount">{{ ___('hub.amount') }}<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="amount" id="amount" class="form-control input-style-1" value="{{old('amount')}}" placeholder="{{ ___('placeholder.enter_Amount') }}">
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="amount"></small>
                    </div>

                    <div class="form-group col-md-6 process">
                        <label class="label-style-1" for="from_account">{{ ___('account.from_account') }} <span class="text-danger">*</span> </label>
                        <select id="from_account" name="from_account" class="form-control input-style-1 select2" data-url="{{ route('accounts.search') }}" data-user-id="{{ auth()->user()->id }}">
                            <option selected disabled>{{ ___('menus.select') }} {{ ___('label.from_account') }} </option>
                        </select>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="from_account"></small>
                    </div>

                    <div class="col-12 col-md-6  form-group process">
                        <label class=" label-style-1" for="transaction_id">{{ ___('account.transaction_id') }}<span class="text-danger">*</span> </label>
                        <input id="transaction_id" type="text" name="transaction_id" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_Transaction_ID') }}" autocomplete="off" class="form-control input-style-1" value="{{old('transaction_id')}}">
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="transaction_id"></small>
                    </div>

                    <div class="col-12 col-md-6 form-group process">
                        <label class="label-style-1">{{ ___('account.reference_file') }}<span class="fillable"></span></label>
                        <div class="ot_fileUploader left-side">
                            <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                            <button class="primary-btn-small-input" type="button">
                                <label class="j-td-btn" for="reference_file">{{ ___('label.browse') }}</label>
                                <input type="file" class="d-none form-control" name="reference_file" id="reference_file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                            </button>
                        </div>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="reference_file"></small>
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label class="label-style-1" for="description">{{ ___('hub.description') }}</label>
                        <textarea name="description" id="description" class="form-control input-style-1" placeholder="{{ ___('placeholder.enter_description')}}">{{ old('description') }}</textarea>
                        <small class="text-danger errorTextBox d-none mt-2" data-error-for="description"></small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 col-md-6">
                        <label class="label-style-1">
                            <input type="checkbox" value="1" id="isprocess" name="isprocess" @checked($errors->has('transaction_id') || $errors->has('from_account'))/>
                            {{ ___('hub.is_processed ') }} ?
                        </label>
                    </div>
                </div>

                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                        <a href="{{ route('hub.hub-payment.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }} </span></a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection()


@push('scripts')
<script src="{{ asset('backend/js/custom/hub/payment.js') }}"></script>
@endpush
