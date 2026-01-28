@extends('backend.partials.master')
@section('title')
{{ ___('label.page') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('page.index') }}" class="breadcrumb-link">{{ ___('label.page') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('page.update',[$page->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('label.page') }}
                            </h4>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.page') }} <span class="text-danger">*</span></label>
                                <select name="page" id="select_page" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('Select Page') }} </option>

                                    <option value="about_us" @selected(old('page',$page)=='about_us' )>{{ ___('label.about_us') }} </option>
                                    <option value="privacy_policy" @selected(old('page',$page)=='privacy_policy' )>{{ ___('label.privacy_policy') }} </option>
                                    <option value="terms_conditions" @selected(old('page',$page)=='terms_conditions' )>{{ ___('label.terms_conditions') }} </option>
                                    <option value="service" @selected(old('page',$page)=='service' )>{{ ___('label.service') }} </option>

                                </select>
                                @error('page') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="title" value="{{ old('title',$page->title) }}">
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $page->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label class="label-style-1">{{ ___('label.description') }} </label>
                                <textarea name="description" id="summernote" class="form-control input-style-1 summernote">{{ old('description',$page->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="j-create-btns ml-1">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                        <a href="{{ route('page.index') }}" class="j-td-btn btn-red">
                            <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
