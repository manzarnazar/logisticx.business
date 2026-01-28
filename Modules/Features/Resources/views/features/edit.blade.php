@extends('backend.partials.master')
@section('title')
{{ ___('feature') }} {{ ___('edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('features.index') }}" class="breadcrumb-link">{{ ___('label.features') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('features.update', [$features->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('label.features') }}</h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="title" value="{{ old('title', $features->title) }}">
                                @error('title')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{ getImage($features->upload, 'image_two','default-image-40x40.png') }}">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position', $features->position) }}">
                                @error('position')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" selected>{{ ___('label.active') }} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('label.inactive') }} </option>
                                </select>
                                @error('status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12">
                                <label class=" label-style-1" for="summernote">{{ ___('label.description') }}</label>
                                <textarea class="form-control input-style-1 summernote" name="description" id="summernote" rows="8">{{ $features->description }}</textarea>
                                @error('description')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="j-create-btns ml-1">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                        <a href="{{ route('features.index') }}" class="j-td-btn btn-red">
                            <i class="fa-solid fa-rectangle-xmark pb-1"></i><span>{{ ___('label.cancel') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
