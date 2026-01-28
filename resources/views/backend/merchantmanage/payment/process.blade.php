@extends('backend.partials.master')
@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.payment') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('merchant.merchant') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.manage.payment.index') }}" class="breadcrumb-link">{{ ___('merchant.payment') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.process') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('merchant.payment_process') }}</h4>
                    </div>
                    <form action="{{route('merchantmanage.payment.processed')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')
                        <input type="hidden" value="{{ $payment->id }}" name="id" />
                        <div class="form-row">
                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="transaction_id">{{ ___('merchant.transaction_id') }}<span class="text-danger">*</span> </label>
                                <input id="transaction_id" type="text" name="transaction_id" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_Transaction_ID') }}" autocomplete="off" class="form-control input-style-1" value="{{old('transaction_id')}}" require>
                                @error('transaction_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="from_account">{{ ___('merchant.from_account') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" name="from_account">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('merchant.from_account') }}</option>
                                    @foreach ($accounts as $account)
                                    @if ($account->type == App\Enums\AccountType::ADMIN)
                                    @if ($account->gateway == 1)
                                    <option value="{{ $account->id }}">{{ $account->user->name }} | {{ ___('merchant.cash') }} : {{ $account->balance }}</option>
                                    @elseif($account->gateway == 3 || $account->gateway == 4 || $account->gateway == 5)
                                    <option value="{{ $account->id }}">{{$account->account_holder_name}} |No : {{ $account->mobile }}| @if($account->type == 1) {{ ___('merchant.merchant') }} @else {{ ___('placeholder.persional') }} @endif | {{ ___('merchant.current_balance') }}: {{ $account->balance }} </option>
                                    @else
                                    <option value="{{ $account->id }}">{{$account->account_holder_name}} | A.No : {{ $account->account_no }} | {{ ___('merchant.current_balance') }}: {{ $account->balance }}</option>
                                    @endif
                                    @endif
                                    @endforeach
                                </select>
                                @error('from_account')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group process col-md-6">
                                <label class="label-style-1">{{ ___('merchant.reference_file') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="reference_file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="reference_file" id="reference_file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 col-md-6"></div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><span>{{ ___('label.submit') }}</span></button>
                                <a href="{{ route('merchant.manage.payment.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
