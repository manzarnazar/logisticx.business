@extends('backend.partials.master')
@section('title')
{{ ___('label.service') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('dashboard.website_Setup')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service.index') }}" class="breadcrumb-link">{{ ___('label.service') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('service.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $service->id}}">

            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.edit') }} {{ ___('label.service') }}</h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="title" value="{{ old('title' , $service->title) }}">
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }} <span class="text-danger">*</span> <span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <!-- Image preview -->
                                    <img id="previewImage"
                                         src="{{ getImage($service->upload, 'original', 'default-image-40x40.png') }}"
                                         style="max-width: 100px; height: auto;" alt="service image">

                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouseImage">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouseImage" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                                @error('image')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.banner_image') }} <span class="text-danger">*</span> <span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <!-- Banner image preview -->
                                    <img id="previewBanner"
                                         src="{{ getImage($service->bannerImage, 'original') }}"
                                         style="max-width: 100px; height: auto;" alt="banner image">

                                    <!-- Banner image input field -->
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouseBanner">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="banner_image" id="fileBrouseBanner" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                                @error('banner_image')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position', $service->position) }}">
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $service->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="label-style-1">{{ ___('label.short_description') }} </label>
                                <textarea name="short_description" id="summernote" class="form-control input-style-1 summernote">{{ old('short_description',$service->short_description) }}</textarea>
                                @error('short_description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                             <div class="form-group col-md-12">
                                <label class="label-style-1">{{ ___('label.description') }} </label>
                                <textarea name="description" id="summernote" class="form-control input-style-1 summernote" rows="4">{{ old('short_description',$service->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('service.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>

</div>

@endsection
