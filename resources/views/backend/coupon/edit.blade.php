@extends('backend.partials.master')
@section('title')
{{ ___('menus.coupon') }} {{ ___('label.update') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}" class="breadcrumb-link">{{ ___('menus.coupon') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.update') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="row">
        <!-- basic form -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.update') }} {{ ___('menus.coupon') }} </h4>
                    </div>

                    <form action="{{route('coupon.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')

                        <input type="hidden" name="id" value="{{ $coupon->id }}">

                        <div class="form-row">
                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="type">{{ ___('label.type') }}<span class="text-danger">*</span> </label>
                                <select name="type" id="type" class="form-control input-style-1 select2" data-merchant="{{ App\Enums\CouponType::MERCHANT_WISE->value }}" data-placeholder="{{ ___('placeholder.coupon_type') }}">
                                    <option selected disabled>{{ ___('menus.select') }}</option>

                                    @foreach( config('site.coupon_types') as $key => $type)
                                    <option value="{{ $key }}" @selected(old('type',$coupon->type)==$key)> {{ ___('common.'. $type  ) }}</option>
                                    @endforeach

                                </select>
                                @error('type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group merchant_container">
                                <label class=" label-style-1" for="merchant_id">{{ ___('label.merchant') }}</label>
                                <select name="merchant_id[]" id="merchant_id" class="form-control input-style-1" data-url="{{ route('parcel.merchant.get') }}" multiple @disabled(true)>
                                    <option></option>
                                    @foreach ($merchants as $merchant)
                                    <option value="{{ $merchant->id}}" @selected(true)>{{ $merchant->business_name }}</option>
                                    @endforeach
                                </select>
                                @error('merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="start_date">{{ ___('label.start_date') }} <span class="text-danger">*</span> </label>
                                <input id="start_date" type="date" name="start_date" placeholder="{{ ___('placeholder.start_date') }}" class="form-control input-style-1 flatpickr" value="{{ old('start_date',$coupon->start_date) }}" min="{{ date('Y-m-d') }}" />
                                @error('start_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="end_date"> {{ ___('label.end_date') }} <span class="text-danger">*</span> </label>
                                <input id="end_date" type="date" name="end_date" placeholder="{{ ___('placeholder.end_date') }}" class="form-control input-style-1 flatpickr" value="{{old('end_date',$coupon->end_date)}}" />
                                @error('end_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="discount_type">{{ ___('label.discount_type') }}<span class="text-danger">*</span> </label>
                                <select name="discount_type" id="discount_type" class="form-control input-style-1 select2" data-placeholder="{{ ___('placeholder.discount_type') }}">
                                    <option selected disabled>{{ ___('menus.select') }}</option>
                                    @foreach( config('site.discount_types') as $key => $type)
                                    <option value="{{ $key }}" @selected(old('discount_type',$coupon->discount_type)==$key)> {{ ___('common.'. $type  ) }}</option>
                                    @endforeach
                                </select>
                                @error('discount_type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="discount">{{ ___('label.discount') }} <span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="discount" id="discount" class="form-control input-style-1" value="{{old('discount',$coupon->discount)}}" placeholder="{{ ___('placeholder.amount') }}" />
                                @error('discount') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="coupon"> {{ ___('label.coupon') }} <span class="text-danger">*</span> </label>
                                <input type="text" name="coupon" id="coupon" class="form-control input-style-1" value="{{ old('coupon',$coupon->coupon) }}" placeholder="{{ ___('placeholder.coupon_code') }}" maxlength="20" oninput="this.value = this.value.replace(/\s+/g, '').toUpperCase();" />
                                @error('coupon') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',$coupon->status)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('coupon.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
<script src="{{ asset('backend/js/custom/coupon/curd.js')}}"></script>
@endpush
