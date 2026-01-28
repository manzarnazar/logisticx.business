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
                            <li class="breadcrumb-item"><a href=" " class="breadcrumb-link">{{ ___('hub.title') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('hub.submit_request') }}</h4>
                    </div>

                    <form action="{{route('merchant-panel.payment-request.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf

                        <div class="form-row">

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="merchant">{{ ___('merchant.merchant_account') }}<span class="text-danger">*</span> </label>
                                <select id="merchant_account" class="form-control input-style-1 select2" name="merchant_account">
                                    <option disabled>{{ ___('menus.select') }} {{ ___('merchant.merchant') }} {{ ___('account.accounts') }}</option>
                                    @foreach ($accounts as $account )
                                    <option value="{{ $account->id }}">{{ $account->text }}</option>
                                    @endforeach
                                </select>
                                @error('merchant_account') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="amount">{{ ___('merchant.amount') }}<span class="text-danger">*</span> </label>
                                <input type="number" step="any" id="amount" name="amount" placeholder="{{ ___('placeholder.enter_Amount') }}" class="form-control input-style-1" value="{{old('amount')}}" readonly>
                                @error('amount') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="description">{{ ___('merchant.description') }}</label>
                                <textarea name="description" placeholder="{{ ___('placeholder.enter_description') }}" class="form-control input-style-1">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <label class="label-style-1" for="note">{{ ___('label.parcel_list') }}</label>
                                <div class="table-responsive">
                                    @error('parcel_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                    <table id="table" class="table   parcelTable">
                                        <thead class="bg">
                                            <th><input type="checkbox" id="allCheckBox" /></th>
                                            <th>{{ ___('parcel.tracking_id') }}</th>
                                            <th>{{ ___('parcel.cash_collection') }}</th>
                                            <th>{{ ___('parcel.delivery_charge') }}</th>
                                            <th>{{ ___('parcel.receivable') }}</th>
                                            <th>{{ ___('parcel.date') }}</th>
                                        </thead>
                                        <tbody id="parcelList">

                                            @forelse ($parcels as $parcel)
                                            <tr>
                                                <td> <input type='checkbox' id='parcel_{{ $parcel->id}}' class="parcels" value='{{ $parcel->id}}' name='parcel_id[]' data-cod="{{ $parcel->parcelTransaction->cash_collection}}" data-charge="{{ $parcel->parcelTransaction->total_charge}}" /> </td>
                                                <td> <label for="parcel_{{ $parcel->id }}"> {{ $parcel->tracking_id }} </label> </td>
                                                <td> {{ settings('currency') }} {{ $parcel->parcelTransaction->cash_collection}}</td>
                                                <td> {{ settings('currency') }} {{ $parcel->parcelTransaction->total_charge}}</td>
                                                <td> {{ settings('currency') }} {{ $parcel->parcelTransaction->cash_collection - $parcel->parcelTransaction->total_charge}}</td>
                                                <td> {{ dateFormat($parcel->delivery_date) }} </td>
                                            </tr>
                                            @empty
                                            <x-nodata-found :colspan="6" />
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('merchant-panel.payment-request.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></a>
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
<script src="{{ asset('backend/js/custom/merchant/payment_request.js') }}"></script>
@endpush
