@extends('backend.partials.master')
@section('title')
{{ ___('parcel.deliveryman') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.index') }}" class="breadcrumb-link">{{ ___('parcel.deliveryman') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->


    <div class="j-create-main">
        <form action="{{route('deliveryman.update',['id'=>$deliveryman->id])}}" method="POST" enctype="multipart/form-data" id="basicform">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- basic form -->
                <div class="col-12">
                    <div class="form-inputs">

                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('parcel.edit_deliveryman') }}</h4>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="Name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" autocomplete="off" class="form-control input-style-1  @error('name') is-invalid @enderror" value="{{old('name',$deliveryman->user->name)}}" require>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="email">{{ ___('label.email') }}<span class="text-danger">*</span> </label>
                                <input id="email" type="text" name="email" placeholder="{{ ___('placeholder.email') }}" autocomplete="off" class="form-control input-style-1  @error('email') is-invalid @enderror" value="{{old('email',$deliveryman->user->email)}}">
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="mobile">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                                <input id="mobile" type="tel" step="any" name="mobile" placeholder="{{ ___('placeholder.enter_phone') }}" autocomplete="off" class="form-control input-style-1  @error('mobile') is-invalid @enderror" value="{{old('mobile',$deliveryman->user->mobile)}}">
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="password">{{ ___('label.password') }}</label>
                                <input id="password" type="password" name="password" placeholder="{{ ___('placeholder.enter_password') }}" autocomplete="off" class="form-control input-style-1" value="{{old('password')}}">
                                @error('password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="input-select">{{ ___('label.hub') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="input-select" name="hub_id" required>
                                    @foreach($hubs as $hub)
                                    <option value="{{$hub->id}}" {{ (old('hub_id',$deliveryman->user->hub_id) == $hub->id) ? 'selected' : '' }}>{{$hub->name}}</option>
                                    @endforeach
                                </select>
                                @error('hub') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6 pt-1">
                                <label class="label-style-1" for="input-select">{{ ___('label.salary') }}</label>
                                <input type="text" class="form-control input-style-1 " placeholder="{{ ___('common.title') }}" name="salary" value="{{ $deliveryman->user->salary }}" />
                                @error('salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{ getImage($deliveryman->user->upload, 'original','default-image-40x40.png')}}" alt="">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.image') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/jpg, image/jpeg, image/png">
                                    </button>
                                </div>
                                @error('image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.driving_license') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly="" id="placeholder">
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="dl_id">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="driving_license" id="dl_id" accept="image/jpeg, image/jpg, image/png, image/webp, application/pdf">
                                    </button>
                                </div>
                                @error('driving_license') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="pickup_slot">{{ ___('label.pickup_slot') }}<span class="text-danger">*</span> </label>
                                <select name="pickup_slot" id="pickup_slot" class="form-control input-style-1  select2">
                                    @foreach($pickupSlots as $pickupSlot)
                                    <option value="{{ $pickupSlot->id }}" @selected(old('pickup_slot',$deliveryman->pickup_slot_id)==$pickupSlot->id)>{{ $pickupSlot->title }}</option>
                                    @endforeach
                                </select>
                                @error('pickup_slot') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="coverage">{{ ___('menus.coverage') }} Area <span class="text-danger">*</span> </label>
                                <select name="coverage" id="coverage" class="form-control input-style-1  select2">
                                    <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }}</option>

                                    @foreach($coverages as $coverage)

                                    <option value="{{ $coverage->id}}" @selected(old('coverage',$deliveryman->coverage_id)==$coverage->id)> {{ $coverage->name }}</option>

                                    <x-coverage-child :coverage="$coverage" :old="$deliveryman->coverage_id" name="coverage" />

                                    @endforeach

                                </select>
                                @error('coverage') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="address" class="col-form-label text-sm-right">{{ ___('label.address') }}<span class="text-danger">*</span> </label>
                                <textarea name="address" placeholder="{{ ___('placeholder.address') }}" id="address" class="form-control input-style-1 ">{{ old('address',$deliveryman->user->address) }}</textarea>
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',$deliveryman->user->status) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="j-create-btns mt-2">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('deliveryman.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                </div>
            </div>
        </form>

    </div>
</div>
<!-- end wrapper  -->
@endsection()
