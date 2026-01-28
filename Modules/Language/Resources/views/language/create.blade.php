@extends('backend.partials.master')
@section('title')
{{ ___('language.title') }} {{ ___('label.add') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('language.index')}}" class="breadcrumb-link">{{ ___('language.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site">{{ ___('label.create')}} {{ ___('language.title') }}</h4>
                    </div>

                    <form action="{{route('language.store')}}" method="POST">
                        @csrf

                        <div class="form-row">

                            <div class="form-group col-md-6 ">
                                <label class="label-style-1" for="name">{{ ___('label.name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control input-style-1" value="{{ old('name') }}" placeholder="{{ ___('placeholder.enter_name') }}">
                                @error('name') <small class="pt-2 text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6 ">
                                <label class="label-style-1" for="code">{{ ___('label.code') }} <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control input-style-1" value="{{ old('code') }}" placeholder="{{ ___('placeholder.enter_language_code') }}">
                                @error('code') <small class="pt-2 text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="icon_class">{{ ___('label.flag_icon') }} <span class="text-danger">*</span></label>
                                <select name="icon_class" id="icon_class" class="form-control input-style-1 select2" data-placeholder="{{ ___('placeholder.select_an_option') }}">
                                    <option></option>
                                    @foreach ($flags as $flag)
                                    <option value="{{ $flag->icon_class }}" data-icon="{{ $flag->icon_class }}">{{ strtoupper($flag->title) }}</option>
                                    @endforeach
                                </select>
                                @error('icon_class') <small class="pt-2 text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="text_direction">{{ ___('language.text_direction') }}</label>
                                <select class="form-control input-style-1  select2" id="text_direction" name="text_direction">
                                    <option value="ltr" @selected(old('text_direction','ltr')=='ltr' )>{{ ___('language.ltr') }}</option>
                                    <option value="rtl" @selected(old('text_direction')=='rtl' )>{{ ___('language.rtl') }}</option>
                                </select>
                                @error('text_direction') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" selected>{{ ___('label.active')}} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('label.inactive')}} </option>
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk pr-1"></i> <span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('language.index') }}" class="j-td-btn btn-red"> <span><i class="fa-solid fa-rectangle-xmark pr-1"></i> <span>{{ ___('label.cancel') }}</span></span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')

<script src="{{ asset('backend/js/custom/language/language_curd.js')}}"></script>

@endpush
