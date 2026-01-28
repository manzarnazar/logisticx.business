@extends('backend.partials.master')
@section('title')
{{ ___('label.widgets') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('widgets.index') }}" class="breadcrumb-link">{{ ___('label.widgets') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->


    <div class="j-create-main">
        <form action="{{ route('widgets.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.create') }} {{ ___('label.widgets') }}
                            </h4>
                        </div>

                        <div class="form-row">

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                    <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="title" value="{{ old('title') }}">
                                    @error('title') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>


                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.section') }} <span class="text-danger">*</span></label>
                                <select name="section" class="form-control input-style-1 select2" onchange="showImage()">
                                    <option selected disabled>{{ ___('label.select')}} {{ ___('label.section') }} </option>
                                    @foreach (\Config::get('site.widgets') as $key=>$value)
                                        <option value="{{ $value }}" @if(old('site')==$value) selected @endif>{{ ___("label.$key") }}</option>
                                    @endforeach
                                </select>
                                @error('section') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>
                            
                            <div class="form-group col-12 col-lg-6 demo-image">
                                <div id="image-container" style="display: none;">
                                    <img id="image-to-show" src="" alt="Selected Image" style="max-width: 100%; height: auto; object-fit: contain;" />
                                </div>
                                <p id="image-message" style="display: none;">No demo found!</p>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('parcel.Background') }}</label>
                                <div class="custom-control custom-checkbox d-flex gap-6">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="custom-control-input" id="none" name="background" value="none" checked>
                                        <label class="custom-control-label" for="none">{{ ___('parcel.none') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline ml-5">

                                        <input type="radio" class="custom-control-input" id="bg_color" name="background" value="bg_color">
                                        <label class="custom-control-label" for="bg_color">{{ ___('parcel.bg_color') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline ml-5">

                                        <input type="radio" class="custom-control-input" id="bg_image" name="background" value="bg_image">
                                        <label class="custom-control-label" for="bg_image">{{ ___('parcel.bg_image') }}</label>
                                    </div>

                                </div>
                                
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="background"></small>
                            </div>

                            <div class="col-lg-6 _bg_color d-none" id="_bg_color">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.bg_color') }}</label>
                                    <input type="color" placeholder="{{ ___('placeholder.bg_color') }}" class="form-control input-style-1" name="bg_color" value="{{ old('bg_color',0) }}">
                                    @error('bg_color') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="col-md-6 _bg_image d-none" id="_bg_image">
                                <label class="label-style-1">{{ ___('label.bg_image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{getImage(null)}}" alt=" ">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.image') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="bg_image" id="fileBrouse" accept="image/jpg, image/jpeg, image/png">
                                    </button>
                                </div>
                                @error('image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.section_padding') }} <span class="text-danger">*</span></label>
                                <select name="section_padding[]" class="form-control input-style-1 select2" multiple>
                                    @foreach (App\Enums\SectionPadding::cases() as $sectionPadding)
                                        <option value="{{ $sectionPadding->value }}">
                                            {{ $sectionPadding->label() }} <!-- Format to human-readable name -->
                                        </option>
                                    @endforeach

                                </select>
                                @error('section') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.position') }}</label>
                                    <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',0) }}">
                                    @error('position') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>


                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" selected>{{ ___('label.active')}} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('label.inactive')}} </option>
                                </select>
                                @error('status') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('widgets.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>


</div>

@endsection


@push('scripts')
<script src="{{ asset('backend/js/custom/widgets/widgets.js')}}"></script>
@endpush
