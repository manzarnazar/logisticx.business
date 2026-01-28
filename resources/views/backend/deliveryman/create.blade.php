@extends('backend.partials.master')
@section('title')
{{ ___('parcel.deliveryman') }} {{ ___('label.add') }}
@endsection
@section('maincontent')
<div class="container-fluid">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.index') }}" class="breadcrumb-link">{{ ___('parcel.deliveryman') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{route('deliveryman.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
            @csrf

            <div class="row">
                <!-- basic form -->
                <div class="col-12">
                    <div class="form-inputs">

                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('parcel.create_deliveryman') }}</h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="Name">{{ ___('label.name') }} <sup>*</sup> </label>
                                <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{old('name')}}" require>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="email">{{ ___('label.email') }} <sup>*</sup> </label>
                                <input id="email" type="text" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1" value="{{old('email')}}">
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="mobile">{{ ___('label.phone') }} <sup>*</sup> </label>
                                <input id="mobile" type="tel" name="mobile" placeholder="{{ ___('placeholder.enter_phone') }}" class="form-control input-style-1" value="{{old('mobile')}}" pattern="^(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})$">
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="password">{{ ___('label.password') }} <sup>*</sup> </label>
                                <input id="password" type="password" name="password" placeholder="{{ ___('placeholder.enter_password') }}" class="form-control input-style-1" value="{{old('password')}}">
                                @error('password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="input-select">{{ ___('label.hub') }} <sup>*</sup> </label>
                                <select class="form-control input-style-1 select2" id="input-select" name="hub_id" @required(true)>
                                    <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }} {{ ___('label.hub') }}</option>

                                    @foreach($hubs as $hub)
                                    <option value="{{$hub->id}}" @selected(old('hub_id')==$hub->id)>{{$hub->name}}</option>
                                    @endforeach
                                </select>
                                @error('hub') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="salary">{{ ___('label.salary') }}</label>
                                <input type="number" step="any" name="salary" id="salary" class="form-control input-style-1" placeholder="{{ ___('placeholder.enter_salary') }}" value="{{old('salary',0)}}">
                                @error('salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{@getImage(null)}}" alt="">
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
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="driving_license">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="driving_license" id="driving_license" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                                @error('driving_license') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="pickup_slot">{{ ___('label.pickup_slot') }} <sup>*</sup> </label>
                                <select name="pickup_slot" id="pickup_slot" class="form-control input-style-1 select2">
                                    <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }} {{ ___('label.pickup_slot') }}</option>

                                    @foreach($pickupSlots as $pickupSlot)
                                    <option value="{{ $pickupSlot->id }}" @selected(old('pickup_slot')==$pickupSlot->id) >{{ $pickupSlot->title }}</option>
                                    @endforeach
                                </select>
                                @error('pickup_slot') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="coverage">{{ ___('menus.coverage') }} {{___('common.area')}} <sup>*</sup> </label>
                                <select name="coverage" id="coverage" class="form-control input-style-1 select2">
                                    <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }}</option>

                                    @foreach($coverages as $coverage)

                                    <option value="{{ $coverage->id}}" @selected(old('coverage')==$coverage->id)> {{ $coverage->name }}</option>

                                    <x-coverage-child :coverage="$coverage" name="coverage" />

                                    @endforeach

                                </select>
                                @error('coverage') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="status">{{ ___('label.status') }} <sup>*</sup> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="address" class="col-form-label text-sm-right">{{ ___('label.address') }} <sup>*</sup> </label>
                                <textarea name="address" id="address" class="form-control input-style-1" placeholder="{{ ___('placeholder.address') }}">{{ old('address')  }}</textarea>
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('deliveryman.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                </div>
            </div>
        </form>
    </div>
    <!-- end basic form -->
</div>

@endsection()
