@extends('backend.partials.master')

@section('title')
{{ ___('label.shop_create') }} | {{ ___('menus.merchant') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.shops.index',$merchant_id) }}" class="breadcrumb-link">{{ ___('menus.shop') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>

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
                    <h4 class="title-site">{{ ___('merchant.create_shop') }}</h4>
                </div>

                <div class="card-body">

                    <form action="{{route('merchant.shops.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <input type="hidden" name="merchant_id" value="{{ $merchant_id }}" />

                        <div class="form-row">


                            <div class="col-12 col-md-6">

                                <div class="form-group">
                                    <label class="label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                    <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{old('name')}}">
                                    @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="label-style-1" for="contact">{{ ___('merchant.contact') }}<span class="text-danger">*</span> </label>
                                    <input id="contact" type="tel" name="contact_no" placeholder="{{ ___('placeholder.contact_no') }}" class="form-control input-style-1" value="{{old('contact_no')}}">
                                    @error('contact_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group">
                                    <label class="label-style-1" for="address">{{ ___('merchant.address') }}<span class="text-danger">*</span> </label>
                                    <textarea id="address" placeholder="{{ ___('placeholder.address') }}" name="address" class="form-control input-style-1">{{ old('address') }}</textarea>
                                    @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>

                            </div>


                            <div class="col-12 col-md-6">

                                <div class="form-group w-100">
                                    <label class="label-style-1" for="hub">{{ ___('menus.hub') }} <span class="text-danger">*</span> </label>
                                    <select name="hub" id="hub" class="form-control input-style-1 select2">
                                        <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }}</option>

                                        @foreach($hubs as $hub)
                                        <option value="{{ $hub->id}}" @selected(old('hub')==$hub->id)> {{ $hub->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('hub') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>

                                <div class="form-group w-100">
                                    <label class="label-style-1" for="status">{{ ___('label.status')}}<span class="text-danger">*</span> </label>
                                    <select name="status" class="form-control input-style-1 select2">
                                        @foreach(config('site.status.default') as $key => $status)
                                        <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('merchant.shops.index',$merchant_id) }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection()
