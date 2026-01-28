@extends('backend.partials.master')
@section('title')
{{ ___('common.support') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('support.index') }}" class="breadcrumb-link">{{ ___('common.support') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('common.support_add') }}</h4>
            </div>
            <form action="{{route('support.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-row">

                    <div class="col-12 col-md-6 form-group">
                        <label class=" label-style-1" for="subject">{{ ___('common.subject') }}<span class="text-danger">*</span> </label>
                        <input id="subject" type="text" name="subject" placeholder="{{ ___('placeholder.enter_Subject') }}" class="form-control input-style-1" value="{{old('subject')}}">
                        @error('subject')
                        <small class="text-danger mt-2">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label class=" label-style-1" for="service">{{ ___('common.service') }}<span class="text-danger">*</span> </label>
                        <select id="service" name="service" class="form-control input-style-1 select2">
                            <option disabled selected>{{ ___('menus.select') }} {{ ___('common.service') }}</option>

                            @foreach(config('site.support.services') as $key => $value)
                            <option value=" {{ $key }}" @selected(old('service')==$key)> {{ ___("common.".$value) }} </option>
                            @endforeach

                        </select>
                        @error('service') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label class=" label-style-1" for="priority">{{ ___('common.priority') }}<span class="text-danger">*</span> </label>
                        <select name="priority" class="form-control input-style-1 select2">
                            <option disabled selected>{{ ___('menus.select') }} {{ ___('common.priority') }}</option>

                            @foreach(config('site.support.priority') as $key => $value)
                            <option value=" {{ $key }}" @selected(old('priority')==$key)> {{ ___("common.".$value) }} </option>
                            @endforeach

                        </select>
                        @error('priority') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label class=" label-style-1" for="department_id">{{ ___('common.department_id') }}</label>
                        <select class="form-control input-style-1 select2" id="department_id" name="department_id">
                            <option disabled selected>{{ ___('menus.select') }} {{ ___('common.department') }}</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}" {{(old('department_id') == $department->id) ? 'selected' : ''}}>{{$department->title}}</option>
                            @endforeach
                        </select>
                        @error('department_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12 col-md-6 form-group">
                        <label class="label-style-1" for="date">{{ ___('common.date')}}<span class="text-danger">*</span> </label>
                        <input type="date" name="date" class="form-control input-style-1 flatpickr" value="{{old('date',date('Y-m-d'))}}">
                        @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    {{-- file new --}}

                    <div class="col-md-6">
                        <label class="label-style-1">{{ ___('common.attached') }}<span class="fillable"></span></label>

                        <div class="ot_fileUploader left-side mb-3">
                            <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                            <button class="primary-btn-small-input" type="button">
                                <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                <input type="file" class="d-none form-control" name="attached_file" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                            </button>
                        </div>
                    </div>


                    <div class="col form-group">
                        <label class=" label-style-1" for="descriptions">{{ ___('common.description')}}</label>
                        <textarea class="form-control input-style-1 summernote" name="description" id="descriptions" placeholder="{{ ___('placeholder.enter_description') }}">{{ old('description') }}</textarea>
                        @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <a href="{{ route('support.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection()
