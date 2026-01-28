@extends('backend.partials.master')
@section('title')
{{ ___('account.income') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('income.index') }}" class="breadcrumb-link">{{ ___('account.income') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('account.create_income') }}</h4>
                    </div>
                    <form action="{{ route('income.store') }}" method="POST" enctype="multipart/form-data" id="incomeForm">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6 ">
                                <label class="label-style-1" for="account_head_id">{{ ___('label.account_heads') }} <span class="text-danger">*</span> </label>
                                <select id="account_head_id" name="account_head_id" class="form-control input-style-1 select2" data-account-balance-url="{{ route('accounts.current-balance') }}">
                                    <option value="0" selected disabled>{{ ___('menus.select') }} {{ ___('label.account_heads') }}</option>
                                    @foreach ($accountHeads as $head)
                                    <option value="{{ $head->id }}" @if (old('account_head_id')==$head->id) selected @endif> {{ $head->name }} </option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_head_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-other d-none">
                                <label class="label-style-1" for="title">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input id="title" type="text" name="title" placeholder="Enter Title" class="form-control input-style-1">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="title"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-merchant d-none">
                                <label class="label-style-1" for="merchant_id">{{ ___('parcel.merchant') }}<span class="text-danger">*</span> </label>
                                <select id="merchant_id" name="merchant_id" class="form-control input-style-1 select2" data-url="{{ route('merchant.search') }}" data-parcel-url="{{ route('parcel.chargeUnpaid') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('merchant.merchant') }} </option>
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="merchant_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-hub inputs-delivery-man d-none">
                                <label class="label-style-1" for="hub_id">{{ ___('parcel.hub') }} <span class="text-danger">*</span> </label>
                                <select id="hub_id" name="hub_id" class="form-control input-style-1  select2" data-parcel-url="{{ route('parcel.cashInHub') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('hub.title') }} </option>
                                    @forelse ($hubs as $hub)
                                    <option value="{{ $hub->id }}" @selected(old('hub_id'))> {{ $hub->name }}</option>
                                    @empty
                                    <option value="{{ auth()->user()->hub->id }}" @selected(true)> {{ auth()->user()->hub->name }}</option>
                                    @endforelse
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-hub inputs-delivery-man d-none">
                                <label class="label-style-1" for="hub_account_id">{{ ___('label.hub_account') }} <span class="text-danger">*</span> </label>
                                <select id="hub_account_id" name="hub_account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.searchByHub') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.hub_account') }} </option>
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_account_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-delivery-man d-none">
                                <label class="label-style-1" for="delivery_man_id">{{ ___('parcel.deliveryman') }}<span class="text-danger">*</span> </label>
                                <select id="delivery_man_id" name="delivery_man_id" class="form-control input-style-1 select2" data-url="{{ route('deliveryman.search') }}" data-parcel-url="{{ route('parcel.cashCollectByDeliveryMan') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('parcel.parcel') }} </option>
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="delivery_man_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-hub inputs-merchant inputs-other d-none">
                                <label class="label-style-1" for="account_id">{{ ___('label.to_account') }} <span class="text-danger">*</span> </label>
                                <select id="account_id" name="account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.search') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.to_account') }} </option>
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_id"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="amount">{{ ___('label.amount') }} <span class="text-danger">*</span> </label>
                                <input type="number" class="form-control input-style-1" id="amount" name="amount" value="{{ old('amount') }}" placeholder="{{ ___('placeholder.enter_Amount') }}" readonly>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="amount"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                                <input type="date" id="date" name="date" placeholder="Enter Date" class="form-control input-style-1 flatpickr" value="{{ old('date', date('Y-m-d')) }}">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="date"></small>
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.receipt') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="receipt">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="receipt" id="receipt" accept="image/*, file/pdf">
                                    </button>
                                </div>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="receipt"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="note">{{ ___('label.note') }}</label>
                                <textarea class="form-control input-style-1" id="note" name="note" placeholder="{{___('placeholder.write_note')}}"></textarea>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="note"></small>
                            </div>

                        </div>

                        <div class="form-row d-none" id="parcelTableBox">
                            <div class="col-md-12">
                                <label class="label-style-1" for="note">{{ ___('label.parcel_list') }}</label>
                                <div class="table-responsive">
                                    <table id="table" class="table  ">
                                        <thead class="bg">
                                            <th><input type="checkbox" id="allCheckBox" /></th>
                                            <th>{{ ___('parcel.tracking_id') }}</th>
                                            <th>{{ ___('parcel.cash_collection') }}</th>
                                            <th>{{ ___('parcel.delivery_charge') }}</th>
                                            <th>{{ ___('parcel.delivery_date') }}</th>
                                        </thead>
                                        <tbody id="parcelList">

                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="parcel_id"></small>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('income.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
<script type="text/javascript">
    const fromDeliveryMan = "{{ \App\Enums\FixedAccountHeads::ReceiveFromDeliveryMan }}";
    const fromHub = "{{ \App\Enums\FixedAccountHeads::ReceiveFromHub }}";
    const fromMerchant = "{{ \App\Enums\FixedAccountHeads::ReceiveFromMerchant }}";
    const accountBalanceUrl = "{{ route('accounts.current-balance') }}";

</script>
<script src="{{ asset('backend/js/custom/income/income_curd.js') }}"></script>
@endpush
