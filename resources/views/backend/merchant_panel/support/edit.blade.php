@extends('backend.partials.master')
@section('title')
{{ ___('common.support') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.support.index') }}" class="breadcrumb-link">{{ ___('common.support') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- basic form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('common.support_add') }}</h4>
                    </div>
                    <form action="{{route('merchant-panel.support.update',['id'=>$singleSupport->id])}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('put')
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="subject">{{ ___('common.subject') }}<span class="text-danger">*</span> </label>
                                <input id="subject" type="text" name="subject" placeholder="{{ ___('placeholder.enter_Subject') }}" autocomplete="off" class="form-control input-style-1" value="{{old('subject',$singleSupport->subject)}}" require>
                                @error('subject') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="department_id">{{ ___('common.department_id') }}</label>
                                <select class="form-control input-style-1 select2" id="department_id" name="department_id">
                                    <option disabled selected>{{ ___('merchant.department') }}</option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}" @selected(old('department_id',$singleSupport->department_id) == $department->id)>{{$department->title}}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="service">{{ ___('common.service') }}<span class="text-danger">*</span> </label>
                                <select name="service" class="form-control input-style-1 select2" id="service">
                                    <option></option>
                                    @foreach( config('site.support.services') as $service)
                                    <option value="{{ $service }}" @selected(old('service',$singleSupport->service)==$service)>{{ ___('common.'.$service) }}</option>
                                    @endforeach
                                </select>
                                @error('service') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="priority">{{ ___('common.priority') }}<span class="text-danger">*</span> </label>
                                <select name="priority" class="form-control input-style-1 select2" id="priority">
                                    <option></option>
                                    @foreach( config('site.support.priority') as $priority)
                                    <option value="{{ $priority }}" @selected(old('priority',$singleSupport->priority)==$priority)>{{ ___('label.'.$priority) }}</option>
                                    @endforeach
                                </select>
                                @error('priority') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('common.attached') }} </label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="attached_file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="attached_file" id="attached_file" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-6  ">
                                <label class="label-style-1" for="date">{{ ___('common.date')}}<span class="text-danger">*</span> </label>
                                <input type="date" name="date" class="form-conselecttrol input-style-1 flatpickr" value="{{old('date',$singleSupport->date)}}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-12">
                                <label class="label-style-1" for="description">{{ ___('common.description') }} </label>
                                <textarea name="description" id="description" class="form-control input-style-1 summernote" rows="3" placeholder="{{ ___('placeholder.enter_description')}}">{{ old('description',$singleSupport->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('merchant-panel.support.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
