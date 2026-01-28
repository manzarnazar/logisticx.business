@extends('backend.partials.master')
@section('title')
{{ ___('parcel.edit_parcel') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('parcel.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.update') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="j-create-main">
        <div class="row">
            <div class="col-xl-8 mb-4 mb-xl-0">
                <div class="form-inputs">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('parcel.edit_parcel') }} </h4>
                    </div>

                    <form action="{{route('parcel.update')}}" method="POST" enctype="multipart/form-data" id="parcelForm">
                        @csrf
                        @method('put')

                        {{-- Hidden inputs --}}
                        <input hidden type="number" id="id" name="id" value="{{ $parcel->id }}">
                        <input type="hidden" id="cod_charge" name="cod_charge" value="{{ old('cod_charge',$parcel->parcelTransaction->cod_charge) }}" />
                        <input type="hidden" id="area" name="area" value="{{ old('area',$parcel->area) }}" data-url="{{ route('coverage.detectArea') }}" />

                        <div class="row">

                            <div class="form-group col-12 col-md-6 @if(auth()->user()->user_type == \App\Enums\UserType::MERCHANT) d-none @endif">
                                <label class="label-style-1" for="merchant_id">{{ ___('merchant.merchant') }} <span class="text-danger">*</span></label>
                                <select id="merchant_id" name="merchant_id" class="form-control" data-url="{{ route('parcel.merchant.get') }}">
                                    <option value="">{{ ___('menus.select') }} {{ ___('merchant.merchant') }}</option>
                                    <option value="{{ $parcel->merchant->id }}" @selected(true)>{{ $parcel->merchant->business_name }} </option>
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="merchant_id"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="shop_id">{{ ___('parcel.shop') }} <span class="text-danger">*</span> </label>
                                <select id="shop_id" class="form-control" name="shop_id" data-url="{{ route('parcel.merchant.shops') }}" data-coverage-id="{{ $parcel->pickup }}">
                                    <option></option>
                                    @foreach ($parcel->merchant->shops as $shop)
                                    <option value="{{ $shop->id }}" @selected(old('shop_id',@$parcel->merchant_shop_id)==$shop->id)>{{ $shop->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="shop_id"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="pickup_phone">{{ ___('parcel.pickup_phone') }} <span class="text-danger">*</span> </label>
                                <input id="pickup_phone" type="text" name="pickup_phone" placeholder="{{ ___('parcel.pickup_phone') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('pickup_phone',@$parcel->pickup_phone) }}">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="pickup_phone"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="pickup_address">{{ ___('parcel.pickup_address') }} <span class="text-danger">*</span> </label>
                                <input id="pickup_address" type="text" name="pickup_address" placeholder="{{ ___('parcel.pickup_address') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('pickup_address',@$parcel->pickup_address) }}">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="pickup_address"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="cash_collection">{{ ___('parcel.cash_collection') }} </label>
                                <input type="number" step="any" class="form-control input-style-1" id="cash_collection" value="{{ old('cash_collection',@$parcel->parcelTransaction->cash_collection) }}" name="cash_collection" placeholder="{{ ___('parcel.cod_including_delivery_fee') }}" onblur="this.value=this.value < 1 ? 0 : this.value">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="cash_collection"></small>

                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="selling_price">{{ ___('parcel.selling_price') }} </label>
                                <input type="text" class="form-control input-style-1 cash-collection" id="selling_price" value="{{ old('selling_price',@$parcel->parcelTransaction->selling_price) }}" name="selling_price" placeholder="{{ ___('parcel.Selling_price_of_parcel') }}" onblur="this.value=this.value < 1 ? 0 : this.value">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="selling_price"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="invoice_no">{{ ___('parcel.invoice') }} </label>
                                <input type="text" name="invoice_no" id="invoice_no" class="form-control input-style-1" value="{{ old('invoice_no',@$parcel->invoice_no) }}" placeholder="{{ ___('parcel.enter_invoice_number') }}" autocomplete="off">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="invoice_no"></small>
                            </div>

                            {{-- customer info  --}}
                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="customer_name">{{ ___('parcel.customer_name') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="customer_name" id="customer_name" class="form-control input-style-1" value="{{ old('customer_name',$parcel->customer_name) }}" placeholder="{{ ___('label.customer_name') }}" autocomplete="off">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="customer_name"></small>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="customer_phone">{{ ___('parcel.customer_phone') }}<span class="text-danger">*</span> </label>
                                <input type="phone" name="customer_phone" id="customer_phone" class="form-control input-style-1" value="{{ old('customer_phone',$parcel->customer_phone) }}" placeholder="{{ ___('label.customer_phone') }}" autocomplete="off">
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="customer_phone"></small>
                            </div>

                            {{-- customer area --}}


                            <div class="col-md-6 form-group">
                                <label class="label-style-1" for="destination">{{ ___('parcel.destination_area') }} Area <span class="text-danger">*</span> </label>
                                <select name="destination" id="destination" class="form-control input-style-1">
                                    <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }}</option>

                                    @foreach($coverages as $coverage)

                                    <option value="{{ $coverage->id}}" @selected(old('destination',$parcel->destination)==$coverage->id)> {{ $coverage->name }}</option>

                                    <x-coverage-child :coverage="$coverage" :old="$parcel->destination" name="destination" />

                                    @endforeach

                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="destination"></small>
                            </div>

                        </div>

                        {{-- customer address and note  --}}
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="customer_address">{{ ___('parcel.customer_address') }}<span class="text-danger">*</span> </label>
                                <textarea name="customer_address" id="customer_address" class="form-control input-style-1" placeholder="{{ ___('placeholder.address') }}">{{ old('customer_address',$parcel->customer_address) }}</textarea>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="customer_address"></small>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <label class=" label-style-1" for="note">{{ ___('parcel.note') }}</label>
                                <textarea id="note" name="note" class="form-control input-style-1" placeholder="{{ ___('placeholder.note') }}">{{ old('note',$parcel->note) }}</textarea>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="note"></small>
                            </div>
                        </div>

                        <div class="row">
                            @if (settings('fragile_liquid_status') == \App\Enums\Status::ACTIVE)
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('parcel.liquid_check_label') }}</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="fragileLiquid" name="fragileLiquid" data-amount="{{ $parcel->parcelTransaction->liquid_fragile_charge }}" @checked(old('fragileLiquid', $parcel->parcelTransaction->liquid_fragile_charge) > 0)>
                                    <label class="custom-control-label d-flex align-items-center" for="fragileLiquid">{{ ___('parcel.liquid_fragile') }}</label>
                                </div>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="fragileLiquid"></small>
                            </div>
                            @endif

                            {{-- Value Added Service --}}
                            <div class="form-group col-md-6" id="vasDiv">
                                <label class=" label-style-1" for="vas">{{ ___('parcel.vas') }}</label>
                                <select name="vas[]" id="vas" class="form-control" multiple data-vas-charge="{{ $parcel->parcelTransaction->vas_charge}}">
                                    <option></option>
                                    @foreach ($ValueAddedServices as $vas)
                                    <option value="{{ $vas->id }}" data-price="{{ $vas->price }}" @selected(in_array($vas->id, old('vas',$existingVASIds)))> {{ $vas->name . ' - ' . $vas->price }} </option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="vas"></small>
                            </div>

                            {{-- product category --}}
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="product_category">{{ ___('parcel.product_category') }} <span class="text-danger">*</span></label>
                                <select name="product_category" id="product_category" class="form-control input-style-1 ">
                                    <option></option>
                                    @foreach ($productCategories as $category)
                                    <option value="{{ $category->id }}" @selected(old('product_category',$parcel->product_category_id)==$category->id)>{{ $category->name }}</option>
                                    @endforeach

                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="product_category"></small>
                            </div>

                            {{-- service type --}}
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="service_type">{{ ___('parcel.service_type') }} <span class="text-danger">*</span> </label>
                                <select name="service_type" id="service_type" class="form-control" data-url="{{ route('parcel.serviceType') }}">
                                    <option></option>
                                    @foreach ($serviceTypes as $serviceType )
                                    <option value="{{ $serviceType->id}}" @selected(old('service_type',$parcel->service_type_id)==$serviceType->id) >{{ $serviceType->name}}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="service_type"></small>
                            </div>

                            {{-- quantity --}}
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="quantity">{{ ___('parcel.quantity') }} <span class="text-danger">*</span> </label>
                                <input type="number" id="quantity" name="quantity" class="form-control input-style-1" value="{{ old('quantity',$parcel->quantity)}}" placeholder="{{ ___('parcel.quantity') }}" onblur="this.value=this.value < 1 ? 1 : this.value" />
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="quantity"></small>
                            </div>

                            {{-- charge --}}
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="charge">{{ ___('parcel.Delivery_Charge') }} <span class="text-danger">*</span> </label>
                                <input type="number" step="any" id="charge" name="charge" class="form-control input-style-1" value="{{ old('charge',$parcel->parcelTransaction->charge) }}" placeholder="{{ ___('parcel.Delivery_Charge') }}" data-url="{{ route('parcel.merchant.charge') }}" />
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="charge"></small>
                            </div>

                            <div class="col-md-6">
                                <label class=" label-style-1" for="coupon"> {{ ___('label.coupon') }} </label>
                                <div class="input-group d-flex gap-2 align-items-stretch">
                                    <input type="text" name="coupon" id="coupon" class="form-control input-style-1" value="{{ old('coupon',$parcel->coupon) }}" data-discount="{{ $parcel->parcelTransaction->discount }}" placeholder="Enter Coupon" oninput="this.value = this.value.replace(/\s+/g, '').toUpperCase();" data-url="{{ route('coupon.apply') }}" />
                                    <button type="button" id="couponApply" class="input-group-text btn btn-light">Apply</button>
                                </div>
                                <small id="coupon_error_text" class="text-danger errorTextBox d-none mt-2" data-error-for="charge"></small>
                            </div>
                            <div class="form-group col-md-6 @if(auth()->user()->user_type != \App\Enums\UserType::MERCHANT) d-none @endif">
                                <label class="label-style-1">{{ ___('parcel.are_you_want_to_add_parcel_bank') }}</label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_parcel_bank" name="is_parcel_bank" data-amount="0" @checked(old('is_parcel_bank', $parcel->is_parcel_bank))>
                                    <label class="custom-control-label" for="is_parcel_bank">{{ ___('parcel.yes') }}</label>
                                </div>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="is_parcel_bank"></small>
                            </div>
                        </div>

                        <div class="j-create-btns mt-4">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn" data-loading-text="{{ ___('label.processing') }}"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('parcel.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="form-cart">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.charge_details') }} </h4>
                    </div>
                    <div class="j-cart-total">
                        <ul class="j-cart-jj-list">
                            <li>
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.Cash_Collection') }}</p>
                                    <span class="j-cart-value" id="totalCashCollection">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.Delivery_Charge') }}</p>
                                    <span class="j-cart-value" id="chargeAmount">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li class="hideShowLiquidFragile">
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.Liquid/Fragile_Charge') }}</p>
                                    <span class="j-cart-value" id="liquidFragileAmount">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li class="hideShowCOD">
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.cod_charge') }}</p>
                                    <span class="j-cart-value" id="codAmount">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li class="hideShowVAS">
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.vas') }}</p>
                                    <span class="j-cart-value" id="vasAmount">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li class="hideShowDiscount">
                                <div class="jj-cart-full">
                                    <p>{{ ___('label.discount') }}</p>
                                    <span class="j-cart-value" id="discount">{{ ___('0.00') }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.Vat') }}</p>
                                    <span class="j-cart-value" id="VatAmount" data-vat-rate="{{ merchantSetting('merchant_vat', $parcel->merchant_id) }}">{{ $parcel->parcelTransaction->vat_amount  }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="jj-cart-full jj-cart-border-top">
                                    <p>{{ ___('parcel.total_charge') }}</p>
                                    <span class="j-cart-value" id="totalCharge">{{ $parcel->parcelTransaction->total_charge  }}</span>
                                </div>
                            </li>
                            <li>
                                <div class="jj-cart-full">
                                    <p>{{ ___('parcel.Current_payable') }}</p>
                                    <span class="j-cart-value" id="currentPayable">{{ $parcel->parcelTransaction->current_payable  }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/parcel/edit.js') }}"></script>
@endpush
