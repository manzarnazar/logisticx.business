@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.cod_charge') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{route('merchant.codCharge.index',$merchant->id) }}" class="breadcrumb-link">{{ ___('merchant.cod_charge') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4 col-lg-12 col-xl-3">
            <x-backend.merchant.view-card :merchantId="$merchant->id" />
        </div>

        <div class="col-md-8 col-lg-12 col-xl-9">
            <div class="card">

                <div class="form-input-header">
                    <h4 class="title-site">{{ ___('merchant.cod_charge') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{route('merchant.codCharge.update',$merchant->id)}}" method="POST">
                        @csrf
                        @method('put')

                        <div class="row">

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="cod_inside_city">{{ ___('parcel.inside_city') }} (%)<span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="cod_inside_city" id="cod_inside_city" class="form-control input-style-1 " value="{{ old('cod_inside_city', merchantSetting('cod_inside_city', $merchant->id)) }}" placeholder="Enter Charge" @if(!hasPermission('cod_and_other_update')) disabled @endif />
                                @error('cod_inside_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="cod_sub_city">{{ ___('parcel.sub_city') }} (%)<span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="cod_sub_city" id="cod_sub_city" class="form-control input-style-1 " value="{{ old('cod_sub_city', merchantSetting('cod_sub_city', $merchant->id)) }}" placeholder="Enter Charge" @if(!hasPermission('cod_and_other_update')) disabled @endif />
                                @error('cod_sub_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="cod_outside_city">{{ ___('parcel.outside_city') }} (%)<span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="cod_outside_city" id="cod_outside_city" class="form-control input-style-1 " value="{{ old('cod_outside_city', merchantSetting('cod_outside_city', $merchant->id)) }}" placeholder="Enter Charge" @if(!hasPermission('cod_and_other_update')) disabled @endif />
                                @error('cod_outside_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="liquid_fragile">{{ ___('parcel.liquid_fragile') }} (%) <span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="liquid_fragile" id="liquid_fragile" class="form-control input-style-1 " value="{{ old('liquid_fragile', merchantSetting('liquid_fragile', $merchant->id)) }}" placeholder="Enter Charge" @if(!hasPermission('cod_and_other_update')) disabled @endif />
                                @error('liquid_fragile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="merchant_vat">{{ ___('parcel.merchant_vat') }} (%) <span class="text-danger">*</span> </label>
                                <input type="number" step="any" name="merchant_vat" id="vat" class="form-control input-style-1" value="{{ old('merchant_vat', merchantSetting('merchant_vat', $merchant->id)) }}" placeholder="Enter merchant vat" />
                                @error('merchant_vat') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        @if(hasPermission('merchant_cod_charge_update'))
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>
                            </div>
                        </div>
                        @endif

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection()
