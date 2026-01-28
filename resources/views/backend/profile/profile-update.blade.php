@extends('backend.profile.master')
@section('title')
{{ ___('menus.profile') }}
@endsection
@section('content')
<div id="update_profile">
    <div class="settings-form j-text-body">
        <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label class=" label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                    <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{ old('name',$user->name) }}">
                    @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label class="label-style-1" for="email">{{ ___('label.email') }}<span class="text-danger">*</span> </label>
                    <input id="email" type="text" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1" value="{{old('email',$user->email)}}">
                    @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label class="label-style-1" for="mobile">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                    <input id="mobile" type="tel" step="any" name="mobile" placeholder="{{ ___('placeholder.enter_phone') }}" class="form-control input-style-1" value="{{old('mobile',$user->mobile)}}">
                    @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6">
                    <label class="label-style-1" for="image">{{ ___('label.image') }}<span class="fillable"></span></label>
                    <div class="ot_fileUploader left-side mb-3">
                        <img src="{{getImage(@$user->upload, 'original','default-image-40x40.png')}}" alt=" " class="rounded">
                        <input class="form-control input-style-1" type="text" placeholder="{{ ___('label.image') }}" readonly="" id="placeholder">
                        <button class="primary-btn-small-input" type="button">
                            <label class="j-td-btn" for="image">{{ ___('label.browse') }}</label>
                            <input type="file" class="d-none form-control" name="image" id="image" accept="image/*">
                        </button>
                    </div>
                    @error('image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-md-6">
                    <label class=" label-style-1" for="address">{{ ___('label.address') }}<span class="text-danger">*</span> </label>
                    <textarea name="address" class="form-control input-style-1" rows="3" placeholder="{{ ___('placeholder.address') }}">{{ old('address',$user->address) }}</textarea>
                    @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                </div>

            </div>

            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('profile') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection()
