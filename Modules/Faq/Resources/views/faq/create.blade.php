@extends('backend.partials.master')

@section('title')
{{ ___('label.faq') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.website_setup') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}" class="breadcrumb-link">{{ ___('label.faqs') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('faq.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.faq') }} {{ ___('label.create') }}
                            </h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="title" value="{{ old('title') }}">
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" selected>{{ ___('label.active')}} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('label.inactive')}} </option>
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',0) }}">
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.icon (Icon-font only)') }}</label>
                                <input type="text" placeholder="{{ ___('placeholder.example:icofont-calendar') }}" class="form-control input-style-1" name="icon" value="{{ old('icon') }}">
                                @error('icon') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.description') }} <span class="text-danger">*</span></label>
                                <textarea name="description" id="summernote" class="form-control input-style-1" rows="3">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('faq.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection
