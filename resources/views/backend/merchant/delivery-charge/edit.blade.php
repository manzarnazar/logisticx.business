@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.delivery_charge') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
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
                    <h4 class="title-site">{{ ___('merchant.edit_delivery_charge') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{route('merchant.deliveryCharge.update',[$merchant_id,$charge->id])}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('put')

                        @error('uniqueMerchantCharge') @php toast(__($message), 'error') @endphp @enderror

                        <input type="hidden" name="id" value="{{$charge->id}}">
                        <input type="hidden" name="merchant_id" value="{{$merchant_id}}">

                        <div class="form-row">

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="product_category_id">{{ ___('charges.product_category') }} <span class="text-danger">*</span> </label>
                                <select id="product_category_id" name="product_category_id" class="form-control input-style-1 select2" @disabled(true)>
                                    <option selected disabled>{{ ___('menus.select') }}</option>
                                    @foreach($product_categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('product_category_id',$charge->product_category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_category_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="service_type_id">{{ ___('charges.service_type') }} <span class="text-danger">*</span> </label>
                                <select id="service_type_id" name="service_type_id" class="form-control input-style-1 select2" @disabled(true)>
                                    <option selected disabled>{{ ___('menus.select') }}</option>
                                    @foreach($service_types as $service_type)
                                    <option {{ (old('service_type_id',$charge->service_type_id) == $service_type->id) ? 'selected' : '' }} value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_type_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="area">{{ ___('parcel.title') }} <span class="text-danger">*</span></label>
                                <select id="area" name="area" class="form-control input-style-1 select2" @disabled(true)>
                                    <option selected disabled>{{ ___('menus.select') }}</option>
                                    @foreach(App\Enums\Area::cases() as $area)
                                    <option value="{{ $area->value }}" @if(old('area',$charge->area) == $area->value) selected @endif > {{ ___('parcel.'.$area->name) }} </option>
                                    @endforeach
                                </select>
                                @error('area') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="delivery_time">Delivery time (hour) <span class="text-danger">*</span> </label>
                                <input id="delivery_time" type="number" name="delivery_time" placeholder="Enter delivery time" class="form-control input-style-1" value="{{old('delivery_time',$charge->delivery_time)}}" />
                                @error('delivery_time') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="charge">Charge (Per Quantity)<span class="text-danger">*</span> </label>
                                <input id="charge" type="number" step="any" name="charge" placeholder="Enter Charge" class="form-control input-style-1" value="{{old('charge',$charge->charge)}}" />
                                @error('charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="additional_charge">Additional Charge (Per Quantity)</label>
                                <input id="additional_charge" type="number" step="any" name="additional_charge" placeholder="Enter Aditional Charge if any" class="form-control input-style-1" value="{{old('additional_charge',$charge->additional_charge)}}" />
                                @error('additional_charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="position">{{ ___('label.position') }}</label>
                                <input id="position" type="number" name="position" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" value="{{old('position',$charge->position)}}" />
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status', $key) == $charge->status) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn">{{ ___('label.save_changes') }}</button>
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
