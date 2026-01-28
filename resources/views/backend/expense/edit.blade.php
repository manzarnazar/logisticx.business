@extends('backend.partials.master')
@section('title')
{{ ___('account.expense') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('expense.index') }}" class="breadcrumb-link">{{ ___('account.expense') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('account.edit_expense') }}</h4>
                    </div>

                    <form action="{{route('expense.update')}}" method="POST" enctype="multipart/form-data" id="expenseForm">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{ @$expense->id }}">

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="account_head_id">{{ ___('label.account_heads')}}<span class="text-danger">*</span> </label>
                                <select id="account_head_id" name="account_head_id" class="form-control input-style-1 select2" required>
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.account_heads') }}</option>
                                    @foreach($account_heads as $account_head)
                                    @if($account_head->id != \App\Enums\FixedAccountHeads::PaidToMerchant)
                                    <option value="{{ $account_head->id }}" @selected(old('account_head_id',@$expense->account_head_id)==$account_head->id) >{{ $account_head->name}}</option>
                                    @endif
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_head_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-other d-none">
                                <label class="label-style-1" for="title">{{ ___('label.title')}}</label> <span class="text-danger">*</span> </label>
                                <input type="text" name="title" id="title" class="form-control input-style-1" value="{{ old('title',@$expense->title) }}" placeholder="{{ ___('placeholder.enter_title') }}">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="title"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-delivery-man d-none">
                                <label class="label-style-1" for="delivery_man_id">{{ ___('parcel.deliveryman') }}<span class="text-danger">*</span> </label>
                                <select id="delivery_man_id" name="delivery_man_id" class="form-control input-style-1 select2" data-url="{{ route('deliveryman.search') }}" data-parcel-url="{{ route('parcel.unpaidHeroCommission') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('parcel.parcel') }} </option>
                                    @if(@$expense->deliveryman) <option value="{{ @$expense->deliveryman->id }}" selected>{{ @$expense->deliveryman->user->name }}</option> @endif
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="delivery_man_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-hub d-none">
                                <label class="label-style-1" for="hub_id">{{ ___('parcel.hub') }} <span class="text-danger">*</span> </label>
                                <select id="hub_id" name="hub_id" class="form-control input-style-1  select2" data-parcel-url="{{ route('parcel.cashInHub') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('hub.title') }} </option>
                                    @foreach ($hubs as $hub)
                                    <option value="{{ $hub->id }}" @selected(old('hub_id',$expense->hub_id) == $hub->id) > {{ $hub->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_id"></small>
                            </div>

                            <div class="form-group col-md-6 inputs-hub d-none">
                                <label class="label-style-1" for="hub_account_id">{{ ___('label.hub_account') }} <span class="text-danger">*</span> </label>
                                <select id="hub_account_id" name="hub_account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.searchByHub') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.hub_account') }} </option>

                                    @if(@$expense->hub_id)
                                    @foreach ($expense->hub->accounts as $account)
                                    <option value="{{ $account->id }}" @selected(old('hub_account_id',@$expense->hub_account_id) == $account->id) > {{ $account->text }}</option>
                                    @endforeach
                                    @endif

                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="hub_account_id"></small>
                            </div>

                            <div class="form-group col-md-6 ">
                                <label class="label-style-1" for="account_id">{{ ___('label.from_account') }} <span class="text-danger">*</span> </label>
                                <select id="account_id" name="account_id" class="form-control input-style-1 select2" data-url="{{ route('accounts.search') }}" data-user-id="{{ auth()->user()->id }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.from_account') }} </option>
                                    @if(@$expense->account) <option value="{{ @$expense->account->id }}" selected>{{ @$expense->account->text }}</option> @endif
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_id"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="amount">{{ ___('label.amount') }} <span class="text-danger">*</span> </label>
                                <input type="number" step="any" class="form-control input-style-1" id="amount" name="amount" value="{{ old('amount',@$expense->amount) }}" placeholder="{{ ___('placeholder.enter_Amount') }}" readonly>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="amount"></small>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                                <input type="date" id="date" name="date" placeholder="Enter Date" class="form-control input-style-1 flatpickr" value="{{ old('date',@$expense->date) }}">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="date"></small>
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.receipt')}}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="Attach receipt" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="receipt">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="receipt" id="receipt" accept="image/*, file/pdf">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="note">{{ ___('label.note') }}</label>
                                <textarea class="form-control input-style-1" id="note" name="note">{{ @$expense->note }}</textarea>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="note"></small>
                            </div>

                        </div>

                        <div class="form-row inputs-delivery-man d-none" id="parcelTableBox">
                            <div class="col-md-12">
                                <label class="label-style-1" for="note">{{ ___('label.parcel_list')}}</label>
                                <div class="table-responsive">
                                    <table id="table" class="table   parcelTable">
                                        <thead class="bg">
                                            <th><input type="checkbox" id="allCheckBox" /></th>
                                            <th>{{ ___('parcel.tracking_id') }}</th>
                                            <th>{{ ___('parcel.commission') }}</th>
                                            <th>{{ ___('parcel.date') }}</th>
                                        </thead>
                                        <tbody id="parcelList" data-url="{{ route('parcel.unpaidHeroCommission') }}">

                                            @foreach ($expense->heroCommissions as $commission)
                                            <tr>
                                                <td> <input type='checkbox' @checked(true) id='parcel_{{ $commission->parcel_id}}' class="parcels" value='{{ $commission->parcel_id}}' name='parcel_id[]' data-commission="{{ $commission->amount}}" /> </td>
                                                <td> <label for="parcel_{{ $commission->parcel_id }}"> {{ $commission->parcel->tracking_id }} </label> </td>
                                                <td> {{ $commission->amount}}</td>
                                                <td> {{ $commission->parcel->delivery_date }} </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('expense.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
    const payHero = "{{ \App\Enums\FixedAccountHeads::PayDeliveryManCommission }}";
    const payHub = "{{ \App\Enums\FixedAccountHeads::PayToHub }}";

</script>

<script src="{{ asset('backend/js/custom/expense/custom.js') }}"></script>

@endpush
