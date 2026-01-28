@extends('backend.partials.master')
@section('title')
{{ ___('label.testimonial') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('dashboard.website_Setup') }}</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('testimonial.index') }}" class="breadcrumb-link">{{ ___('label.testimonial') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.update') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('testimonial.update', ['id' => $testimonial->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.edit') }} {{ ___('label.testimonial') }}
                            </h4>
                        </div>

                        <div class="form-row ">

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.client_name') }} <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="{{ ___('label.client_name') }}" class="form-control input-style-1" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}">
                                    @error('client_name')
                                    <p class="pt-2 text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.client_designation') }} <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="{{ ___('label.client_designation') }}" class="form-control input-style-1" name="designation" value="{{ old('designation', $testimonial->designation) }}">
                                    @error('designation') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.client_image') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side">
                                    <img src="{{ getImage($testimonial->upload, 'image_one','default-image-80x80.png') }}" alt="">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.rating') }} <span class="text-danger">*</span></label>
                                <select name="rating" class="form-control input-style-1 select2">
                                    <option value="">{{ ___('label.select') }} {{ ___('label.rating') }}</option>

                                    @for ($i = 0.5; $i <= 5; $i +=0.5) <option value="{{ $i }}" @if (old('rating', $testimonial->rating) == $i) selected @endif>
                                        {{ $i }}</option>
                                        @endfor

                                </select>
                                @error('rating') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.position') }}</label>
                                    <input type="number" placeholder="{{ ___('label.position') }}" class="form-control input-style-1" name="position" value="0">
                                    @error('position') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" @selected(true)>{{ ___('label.active') }} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('label.inactive') }} </option>
                                </select>
                                @error('status') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="form-group col-6">
                                <label class=" label-style-1" for="summernote">{{ ___('label.review') }} <span class="text-danger">*</span></label>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                <textarea class="form-control input-style-1" name="description" id="summernote" rows="8">{{ $testimonial->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('testimonial.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark pb-1"></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>

</div>
@endsection
