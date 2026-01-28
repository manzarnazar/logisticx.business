@extends('backend.partials.master')
@section('title')
{{ ___('menus.holiday') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('holiday.index') }}" class="breadcrumb-link">{{ ___('menus.holiday') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.add') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="row">
        <!-- basic form -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.add') }} {{ ___('menus.holiday') }} </h4>
                    </div>

                    <form action="{{route('holiday.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="title">{{ ___('label.title') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="title" id="title" class="form-control input-style-1" value="{{ old('title') }}" placeholder="{{ ___('placeholder.enter_title') }}">
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror

                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="days">{{ ___('label.duration') }} <span class="text-danger">*</span> </label>
                                <input id="days" type="date" name="days" placeholder="{{ ___('placeholder.select_holiday_duration') }}" class="form-control input-style-1 flatpickr-range" value="{{ old('days') }}" />
                                @error('days') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                @error('from') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                @error('to') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="description">{{ ___('label.description') }} <span class="text-danger">*</span> </label>
                                <textarea name="description" id="description" class="form-control input-style-1" placeholder="{{ ___('placeholder.enter_description')}}">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.file') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="file" id="file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                                @error('file') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',\App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('holiday.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
@endsection()
