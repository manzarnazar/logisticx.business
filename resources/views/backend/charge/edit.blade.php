@extends('backend.partials.master')
@section('title')
{{ ___('charges.edit_charge') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('charge.index') }}" class="breadcrumb-link">{{ ___('charges.charge') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.update') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="card">
        <div class="card-body">
            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('charges.charge') }}</h4>
            </div>

            <form action="{{route('charges.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')

                @error('uniqueCharge') @php toast(__($message), 'error') @endphp @enderror

                <input type="hidden" name="id" value="{{$charge->id}}">

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="product_category_id">{{ ___('charges.product_category') }} <span class="text-danger">*</span> </label>
                        <select id="product_category_id" name="product_category_id" class="form-control input-style-1  select2">
                            <option value=""></option>
                            @foreach($product_categories as $category)
                            <option value="{{ $category->id }}" {{ (old('product_category_id',$charge->product_category_id) == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('product_category_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        @error('uniqueCharge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="service_type_id">{{ ___('charges.service_type') }} <span class="text-danger">*</span> </label>
                        <select id="service_type_id" name="service_type_id" class="form-control input-style-1  select2">
                            <option value=""></option>
                            @foreach($service_types as $service_type)
                            <option {{ (old('service_type_id',$charge->service_type_id) == $service_type->id) ? 'selected' : '' }} value="{{ $service_type->id }}">{{ $service_type->name }}</option>
                            @endforeach
                        </select>
                        @error('service_type_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="area">{{ ___('parcel.area') }} <span class="text-danger">*</span> </label>
                        <select id="area" name="area" class="form-control input-style-1 select2">
                            <option value=""></option>
                            @foreach(config('site.areas') as $key=> $area)
                            <option value="{{ $key }}" @selected(old('area',$charge->area)==$area)>{{ ___('parcel.'.$area) }}</option>
                            @endforeach
                        </select>
                        @error('area') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="delivery_time"> {{ ___('charges.delivery_time') }} <span class="text-danger">*</span> </label>
                        <input id="delivery_time" type="number" name="delivery_time" placeholder="{{ ___('placeholder.delivery_time') }}" class="form-control input-style-1 " value="{{old('delivery_time',$charge->delivery_time)}}" />
                        @error('delivery_time') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="charge"> {{ ___('charges.charge')  . ' '. ___('charges.per_quantity') }} <span class="text-danger">*</span> </label>
                        <input id="charge" type="number" step="any" name="charge" placeholder="{{ ___('placeholder.charge') }}" class="form-control input-style-1 " value="{{old('charge',$charge->charge)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="additional_charge"> {{ ___('charges.additional_charge') . ' '. ___('charges.per_quantity') }} <span class="text-danger">*</span> </label>
                        <input id="additional_charge" type="number" step="any" name="additional_charge" placeholder="{{ ___('charges.additional_charge')}}" class="form-control input-style-1 " value="{{old('additional_charge',$charge->additional_charge)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('additional_charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="delivery_commission"> {{ ___('charges.delivery_commission') . ' '. ___('charges.per_quantity') }} <span class="text-danger">*</span> </label>
                        <input id="delivery_commission" type="number" step="any" name="delivery_commission" placeholder="{{ ___('charges.delivery_commission')}}" class="form-control input-style-1 " value="{{old('delivery_commission',$charge->delivery_commission)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('delivery_commission') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="additional_delivery_commission"> {{ ___('charges.additional_delivery_commission')  . ' '. ___('charges.per_quantity') }} <span class="text-danger">*</span></label>
                        <input id="additional_delivery_commission" type="number" step="any" name="additional_delivery_commission" placeholder="{{ ___('placeholder.additional_delivery_commission') }}" class="form-control input-style-1 " value="{{old('additional_delivery_commission',$charge->additional_delivery_commission)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('additional_delivery_commission') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="return_charge">{{ ___('charges.return_charge') }} <span class="text-danger">*</span> </label><i class="fa-solid fa-circle-info c-pointer" title="{{ ___('charges.return_charge_info_content') }}"></i>
                        <input id="return_charge" type="number" step="any" name="return_charge" placeholder="{{ ___('charges.return_charge')}}" class="form-control input-style-1 " value="{{old('return_charge',$charge->return_charge)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('return_charge') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="position">{{ ___('label.position') }}</label>
                        <input id="position" type="number" name="position" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1 " value="{{old('position',$charge->position)}}" onblur="this.value = this.value == ''? 0 : this.value" />
                        @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                        <select name="status" class="form-control input-style-1 select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value=" {{ $key }}" @selected(old('status', $charge->status)== $key )>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="j-create-btns mt-2">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                        <a href="{{ route('charge.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection()
