@extends('backend.partials.master')
@section('title')
{{ ___('charges.service_type') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('label.website')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('serviceType') }}" class="breadcrumb-link">{{ ___('label.service_faq') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="card">

        <div class="form-input-header">
            <h4 class="title-site"> {{ ___('label.create') }} {{ ___('label.service_faq') }} </h4>
        </div>

        <div class="card-body">
            <form action="{{route('serviceFaq.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                @csrf

                <div class="form-row">
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="title">{{___('label.title')}}</label> <span class="text-danger small">*</span>
                        <input class="form-control input-style-1 " id="title" type="text" name="title" value="{{old('title')}}" placeholder="{{ ___('placeholder.enter_title') }}" autocomplete="off">
                        @error('title') <span class="text-danger small"> {{$message}}</span> @enderror
                    </div>
                     <div class="form-group col-md-6">
                                <label class=" label-style-1" for="description">{{ ___('label.description') }}<span class="text-danger">*</span> </label>
                                <input id="address" type="text" name="description" placeholder="{{ ___('placeholder.description') }}" class="form-control input-style-1 " value="{{ old('description') }}">
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="service_id">{{ ___('label.service_type') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="service_id" name="service_id" data-placeholder="Select {{ ___('label.service_type') }}" d>
                                    <option></option>
                                    @foreach($service_type as $type)
                                    <option value="{{$type->id}}" @selected(old('service_id')==$type->id)>{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('service_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="position">{{___('label.Position')}}</label>
                        <input type="number" class="form-control input-style-1 " id="position" name="position" value="{{old('position',0)}}" placeholder="Position" autocomplete="off">
                        @error('position') <span class="text-danger small"> {{$message}}</span> @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label class="label-style-1" for="status">               {{___('label.Status')}}
                        </label> <span class="text-danger small">*</span>
                        <select class="form-select input-style-1 select2" name="status" id="status">
                            <option value="1" selected>{{___('label.active')}}</option>
                            <option value="0" @if(old('status')=="0" ) selected @endif>{{___('label.inactive')}}</option>
                        </select>
                        @error('status') <span class="text-danger small"> {{$message}}</span> @enderror
                    </div>
                </div>


                <div class="j-create-btns">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <a href="{{ route('serviceType') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection
