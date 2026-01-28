@extends('backend.partials.master')
@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.payment') }} {{ ___('label.edit') }}
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
                        <h4 class="title-site"> {{ ___('merchant.edit_payment') }}</h4>
                    </div>

                    <form action="{{route('merchantmanage.payment.update')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <input name="id" value="{{ $singlePayment->id }}" type="hidden" />

                        <div class="form-row">
                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="merchant">{{ ___('merchant.merchant') }}<span class="text-danger">*</span> </label>
                                {{-- <input id="mercant_url" data-url="{{ route('merchant-manage.merchant-search') }}" type="hidden" /> --}}
                                <select id="merchant" class="form-control input-style-1" name="merchant" data-url="{{ route('merchant-manage.merchant-search') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('merchant.merchant') }}</option>
                                    @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->id }}" @if ($singlePayment->merchant_id == $merchant->id) selected @endif>{{ $merchant->user->name }} </option>
                                    @endforeach
                                </select>
                                @error('merchant') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="merchant">{{ ___('merchant.merchant_account') }}<span class="text-danger">*</span> </label>
                                <select id="merchant_account" class="form-control input-style-1 select2" name="merchant_account" data-url="{{ route('merchant-manage.merchant.account') }}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('merchant.merchant') }} {{ ___('account.accounts') }}</option>
                                    @foreach ($merchantAccounts as $account)
                                    @if($account->payment_method == 'bank')
                                    <option value='{{ $account->id }}' @if ($account->id == $singlePayment->merchant_account) selected @endif>{{ $account->bank_name }} | {{ $account->account_name }} | {{ $account->account_no }} | {{ $account->branch_name }}</option>
                                    @elseif($account->payment_method == 'mfs')
                                    <option value=' {{ $account->id }}' @if ($account->id == $singlePayment->merchant_account) selected @endif>{{ $account->mfs }} | {{ $account->mobile_no }} | {{ $account->account_type }}</option>
                                    @elseif($account->payment_method == 'cash')
                                    <option value=' {{ $account->id }}' @if ($account->id == $singlePayment->merchant_account) selected @endif>{{ ___('merchant.'.$account->payment_method) }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('merchant_account') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group process">
                                <label class="label-style-1" for="from_account">{{ ___('merchant.from_account') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" name="from_account">
                                    <option disabled selected>{{ ___('menus.select') }} {{ ___('merchant.from_account') }}</option>
                                    @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @selected( old('from_account',$singlePayment->from_account ) == $account->id )>{{ $account->text }} </option>
                                    @endforeach
                                </select>
                                @error('from_account') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group ">
                                <label class="label-style-1" for="amount">{{ ___('merchant.amount') }}<span class="text-danger">*</span> </label>
                                <input id="amount" type="number" step="any" name="amount" placeholder="{{ ___('placeholder.enter_Amount') }}" class="form-control input-style-1" value="{{old('amount',$singlePayment->amount)}}" required readonly>
                                @error('amount') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group process">
                                <label class="label-style-1" for="transaction_id">{{ ___('merchant.transaction_id') }}<span class="text-danger">*</span> </label>
                                <input id="transaction_id" type="text" name="transaction_id" placeholder="{{ ___('placeholder.enter_Transaction_ID') }}" class="form-control input-style-1" value="{{old('transaction_id',$singlePayment->transaction_id)}}">
                                @error('transaction_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
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
                                @error('reference_file') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="description">{{ ___('merchant.description') }}</label>
                                <textarea name="description" placeholder="{{ ___('placeholder.enter_description') }}" class="form-control input-style-1">{{ old('description',$singlePayment->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1">
                                    <input type="checkbox" value="1" id="isprocess" name="isprocess" @checked( $errors->has('transaction_id') || $errors->has('from_account') || $singlePayment->status == \App\Enums\ApprovalStatus::PROCESSED) />
                                    {{ ___('hub.is_processed ') }} ?
                                </label>
                            </div>
                        </div>



                        <div class="form-row" id="parcelTableBox">
                            <div class="col-md-12">
                                <label class="label-style-1" for="note">{{ ___('label.parcel_list') }}</label>
                                @error('parcel_id') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                <div class="table-responsive">
                                    <table id="table" class="table   parcelTable">
                                        <thead class="bg">
                                            <th><input type="checkbox" id="allCheckBox" /></th>
                                            <th>{{ ___('parcel.tracking_id') }}</th>
                                            <th>{{ ___('parcel.cash_collection') }}</th>
                                            <th>{{ ___('parcel.delivery_charge') }}</th>
                                            <th>{{ ___('parcel.date') }}</th>
                                        </thead>
                                        <tbody id="parcelList" data-url="{{ route('merchant.unpaidParcels') }}">

                                            @foreach ($parcels as $parcel)
                                            <tr>
                                                <td><input type='checkbox' @checked(in_array($parcel->id,$pivotParcelsIds->toArray())) id='parcel_{{ $parcel->id}}' class="parcels" value='{{ $parcel->id}}' name='parcel_id[]' data-cod="{{ $parcel->parcelTransaction->cash_collection}}" data-charge="{{ $parcel->parcelTransaction->total_charge}}" /> </td>
                                                <td><label for="parcel_{{ $parcel->id }}"> {{ $parcel->tracking_id }} </label> </td>
                                                <td>{{ $parcel->parcelTransaction->cash_collection}}</td>
                                                <td>{{ $parcel->parcelTransaction->total_charge}}</td>
                                                <td>{{ $parcel->delivery_date }} </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
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

@push('scripts')
<script src="{{ asset('backend/js/custom/merchant/payment_curd.js') }}"></script>
@endpush
