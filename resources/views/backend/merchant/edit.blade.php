    @extends('backend.partials.master')
@section('title')
{{ ___('merchant.edit_merchant') }}
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
                            <li class="breadcrumb-item"><a href="{{route('merchant.index') }}" class="breadcrumb-link">{{ ___('merchant.merchant') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('merchant.edit_merchant') }}</h4>
                    </div>

                    <form action="{{route('merchant.update',$merchant)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" id="id" value="{{$merchant->id}}">
                        {{-- <input id="merchant_unique_id" type="hidden" name="merchant_unique_id"> --}}

                        <div class="form-row">

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="Name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('name',$merchant->user->name) }}" require>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="email">{{ ___('label.email') }}</label>
                                <input id="email" type="text" name="email" placeholder="{{ ___('placeholder.email') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('email',$merchant->user->email) }}">
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="phone">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                                <input id="mobile" type="tel" name="mobile" placeholder="Enter Mobile" autocomplete="off" class="form-control input-style-1" value="{{ old('mobile',$merchant->user->mobile) }}">
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="email">{{ ___('label.password') }}</label>
                                <input id="password" type="password" name="password" placeholder="{{ ___('placeholder.enter_password') }}" autocomplete="off" class="form-control input-style-1" value="{{old('password')}}">
                                @error('password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-md-4">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{getImage($merchant->user->upload)}}" alt=" " class="rounded">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.image') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/jpg, image/jpeg, image/png">
                                    </button>
                                </div>
                                @error('image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-4">
                                <label class=" label-style-1" for="nid_number">{{ ___('label.nid') }}</label>
                                <input id="nid_number" type="number" name="nid_number" value="{{$merchant->user->nid_number}}" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_nid_number') }}" autocomplete="off" class="form-control input-style-1 " value="{{ old('nid_number') }}">
                                @error('nid_number') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="label-style-1">{{ ___('label.nid') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{___('placeholder.nid_image_or_pdf')}}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="nid">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="nid" id="nid" accept="image/jpg, image/jpeg, image/png, application/pdf">
                                    </button>
                                </div>
                                @error('nid') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="business_name">{{ ___('label.business_name') }}<span class="text-danger">*</span> </label>
                                <input id="business_name" type="text" name="business_name" placeholder="{{ ___('placeholder.enter_business_name') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('business_name',$merchant->business_name) }}">
                                @error('business_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="label-style-1">{{ ___('label.trade_license') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{___('placeholder.trade_license_image_or_pdf')}}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="trade_license">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="trade_license" id="trade_license" accept="image/jpg, image/jpeg, image/png, application/pdf">
                                    </button>
                                </div>
                                @error('trade_license') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="hub">{{ ___('label.hub') }} <span class="text-danger">*</span></label>
                                <select class="form-control input-style-1 p-1 select2" id="hub" name="hub">
                                    <option disabled selected>{{ ___('menus.select') }} {{ ___('hub.title') }}</option>
                                    @foreach($hubs as $hub)
                                    <option value="{{ $hub->id }}" @selected(old('hub',$merchant->user->hub_id) == $hub->id)>{{$hub->name}}</option>
                                    @endforeach
                                </select>
                                @error('hub') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="reference_name">{{ ___('label.reference_name') }}</label>
                                <input type="text" id="reference_name" placeholder="{{ ___('label.reference_name') }}" name="reference_name" class="form-control input-style-1" value="{{ old('reference_name',$merchant->reference_name) }}">
                                @error('reference_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="reference_phone">{{ ___('label.reference_phone') }}</label>
                                <input type="tel" id="reference_phone" placeholder="{{ ___('label.reference_phone') }}" name="reference_phone" class="form-control input-style-1" value="{{ old('reference_phone',$merchant->reference_phone) }}">
                                @error('reference_phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="pickup_slot">{{ ___('label.pickup_slot') }}<span class="text-danger">*</span> </label>
                                <select name="pickup_slot" id="pickup_slot" class="form-control input-style-1  select2">
                                    @foreach($pickupSlots as $pickupSlot)
                                    <option value="{{ $pickupSlot->id }}" @selected(old('pickup_slot',$merchant->pickup_slot_id)==$pickupSlot->id)>{{ $pickupSlot->title }}</option>
                                    @endforeach
                                </select>
                                @error('pickup_slot') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',$merchant->user->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label class="label-style-1" for="address">{{ ___('label.address') }}<span class="text-danger">*</span> </label>
                                <textarea id="address" name="address" placeholder="{{ ___('placeholder.address') }}" class="form-control input-style-1">{{old('address',$merchant->address)}}</textarea>
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('merchant.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
