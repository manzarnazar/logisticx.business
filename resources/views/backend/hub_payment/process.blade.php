@extends('backend.partials.master')
@section('title')
{{ ___('hub.title') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href=" {{ route('hub.hub-payment.index') }}" class="breadcrumb-link">{{ ___('hub.title') }}</a></li>
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
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('hub.payment_process') }}</h4>
                    </div>

                    <form action="{{route('hub-payment.processed')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <input type="hidden" value="{{ $payment->id }}" name="id" />
                        <input type="hidden" value="{{ $payment->hub_account_id }}" id="hub_account_id" />

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="from_account">{{ ___('account.from_account') }} <span class="text-danger">*</span> </label>
                                <select id="from_account" name="from_account" class="form-control input-style-1 select2" data-url="{{ route('accounts.search') }}" data-user-id="{{ auth()->user()->id }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.from_account') }} </option>
                                </select>
                                @error('from_account') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-group">
                                <label class="label-style-1" for="transaction_id">{{ ___('hub.transaction_id') }}<span class="text-danger">*</span> </label>
                                <input id="transaction_id" type="text" name="transaction_id" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_Transaction_ID') }}" autocomplete="off" class="form-control input-style-1" value="{{old('transaction_id')}}" require>
                                @error('transaction_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 form-group">
                                <label class="label-style-1">{{ ___('account.reference_file') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="reference_file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="reference_file" id="reference_file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                                @error('reference_file') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><span>{{ ___('label.submit') }}</span></button>
                                <a href="{{ route('hub.hub-payment.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }} </span></a>
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

<script src="{{ asset('backend/js/custom/hub/payment.js') }}"></script>

@endpush
