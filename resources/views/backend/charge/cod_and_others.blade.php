@extends('backend.partials.master')
@section('title')
{{ ___('charges.cod_and_other_charges') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link  ">{{ ___('charges.charges') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('cod-and-others')}}" class="breadcrumb-link active">{{ ___('charges.cod') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('charges.cod_and_other_charges') }} </h4>
            </div>

            <form @if(hasPermission('cod_and_other_update')) action="{{route('cod-and-others.update')}}" @endif method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="cod_inside_city">{{ ___('parcel.inside_city') }} (%)<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="cod_inside_city" id="cod_inside_city" class="form-control input-style-1 " value="{{ old('cod_inside_city', settings('cod_inside_city')) }}" placeholder="{{___('placeholder.charge')}}" @disabled(!hasPermission('cod_and_other_update')) />
                        @error('cod_inside_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="cod_sub_city">{{ ___('parcel.sub_city') }} (%)<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="cod_sub_city" id="cod_sub_city" class="form-control input-style-1 " value="{{ old('cod_sub_city', settings('cod_sub_city')) }}" placeholder="{{___('placeholder.charge')}}" @disabled(!hasPermission('cod_and_other_update')) />
                        @error('cod_sub_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="cod_outside_city">{{ ___('parcel.outside_city') }} (%)<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="cod_outside_city" id="cod_outside_city" class="form-control input-style-1 " value="{{ old('cod_outside_city', settings('cod_outside_city')) }}" placeholder="{{___('placeholder.charge')}}" @disabled(!hasPermission('cod_and_other_update')) />
                        @error('cod_outside_city') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="liquid_fragile">{{ ___('parcel.liquid_fragile') }}<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="liquid_fragile" id="liquid_fragile" class="form-control input-style-1 " value="{{ old('liquid_fragile', settings('liquid_fragile')) }}" placeholder="{{___('placeholder.charge')}}" @disabled(!hasPermission('cod_and_other_update')) />
                        @error('liquid_fragile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="merchant_vat">{{ ___('parcel.merchant_vat') }} (%)<span class="text-danger">*</span> </label>
                        <input type="number" step="any" name="merchant_vat" id="vat" class="form-control input-style-1 " value="{{ old('merchant_vat', settings('merchant_vat')) }}" placeholder="{{___('placeholder.merchant_vat')}}" @disabled(!hasPermission('cod_and_other_update')) />
                        @error('merchant_vat') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>
                @if(hasPermission('cod_and_other_update'))
                <div class="j-create-btns mt-2">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i>{{ ___('label.update') }}</button>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
