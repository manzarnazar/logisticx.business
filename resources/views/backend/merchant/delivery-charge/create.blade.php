@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.delivery_charge') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('merchant.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.deliveryCharge.index',$merchant_id) }}" class="breadcrumb-link">{{ ___('merchant.delivery_charge') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.add') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4 col-lg-12 col-xl-3">
            <x-backend.merchant.view-card :merchantId="$merchant_id" />
        </div>

        <div class="col-md-8 col-lg-12 col-xl-9">
            <div class="card">

                <div class="form-input-header">
                    <h4 class="title-site">{{ ___('merchant.create_delivery_charge') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{route('merchant.deliveryCharge.store',$merchant_id)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf

                        @error('uniqueMerchantCharge') @php toast(__($message), 'error') @endphp @enderror

                        <input type="hidden" id="merchant_id" name="merchant_id" value="{{$merchant_id}}" />
                        <input type="hidden" id="charge_id" name="charge_id" data-url="{{ route('merchant.deliveryCharge.charge',$merchant_id) }}" />

                        <div class="form-row">

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="product_category_id">{{ ___('charges.product_category') }} <span class="text-danger">*</span></label>
                                <select id="product_category_id" name="product_category_id" class="form-control input-style-1 select2">
                                    <option value="" disabled selected>{{ ___('placeholder.select_product_category') }}</option>
                                    @foreach($product_categories as $category)
                                    <option {{ (old('product_category_id') == $category->product_category_id) ? 'selected' : '' }} value="{{ $category->product_category_id }}">{{ $category->productCategory->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_category_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="service_type_id">{{ ___('charges.service_type') }} <span class="text-danger">*</span> </label>
                                <select id="service_type_id" name="service_type_id" class="form-control input-style-1 select2" data-url="{{ route('merchant.deliveryCharge.serviceType',$merchant_id) }}">
                                    <option value="" disabled selected>{{ ___('placeholder.select_service_type') }}</option>
                                </select>
                                @error('service_type_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="area">{{ ___('charges.area') }} <span class="text-danger">*</span> </label>
                                <select id="area" name="area" class="form-control input-style-1 select2" data-url="{{ route('merchant.deliveryCharge.area',$merchant_id) }}">
                                    <option value="" disabled selected>{{ ___('placeholder.select_area') }}</option>
                                </select>
                                @error('area') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="delivery_time">Delivery time (hour) <span class="text-danger">*</span></label>
                                <input id="delivery_time" type="number" name="delivery_time" placeholder="Enter delivery time" class="form-control input-style-1" value="{{old('delivery_time')}}" />
                                @error('delivery_time') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="charge">Charge (Per Quantity)<span class="text-danger">*</span> </label>
                                <input id="charge" type="number" step="any" name="charge" placeholder="Enter Charge" class="form-control input-style-1" value="{{old('charge')}}" />
                                @error('charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="additional_charge">Additional Charge (Per Quantity)</label>
                                <input id="additional_charge" type="number" step="any" name="additional_charge" placeholder="Enter Aditional Charge if any" class="form-control input-style-1" value="{{old('additional_charge')}}" />
                                @error('additional_charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="position">{{ ___('label.position') }}</label>
                                <input id="position" type="number" name="position" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" value="{{old('position',0)}}" />
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="status">{{ ___('label.status') }} <span class="text-danger">*</span> </label>
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
                                <a href="{{ route('merchant.deliveryCharge.index',$merchant_id) }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection()


@push('scripts')

<script src="{{ asset('backend/js/custom/charge/merchant_charge_create.js') }}"></script>

@endpush
