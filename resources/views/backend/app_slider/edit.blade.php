@extends('backend.partials.master')
@section('title')
{{ ___('menus.app_slider') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('app_slider.index') }}" class="breadcrumb-link">{{ ___('menus.app_slider') }}</a></li>
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.update') }} {{ ___('menus.app_slider') }} </h4>
                    </div>

                    <form action="{{route('app_slider.update',$app_slider->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <input hidden type="hidden" id="id" name="id" value="{{ $app_slider->id }}">


                        <div class="form-row">
                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="title">{{ ___('label.title') }} <span class="text-danger">*</span> </label>
                                <input id="title" type="text" name="title" placeholder="{{ ___('placeholder.title') }}" class="form-control input-style-1 " value="{{ old('title',$app_slider->title) }}" />
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="Attach File" readonly="" id="placeholder" fdprocessedid="xgps7j">
                                    <button class="primary-btn-small-input" type="button" fdprocessedid="64bjqb">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="attached_file" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf" style="display: none;">
                                    </button>
                                </div>
                            </div>

                            <div class="col-12 form-group">
                                <label class=" label-style-1" for="descriptions">{{ ___('label.description')}}</label>
                                <textarea class="form-control input-style-1 " name="description" id="descriptions" placeholder="{{ ___('placeholder.enter_description') }}">{{ old('description',$app_slider->description) }}</textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="position"> {{ ___('label.position') }} <span class="text-danger">*</span> </label>
                                <input id="position" type="number" name="position" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1 " value="{{old('position',$app_slider->position)}}" />
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-12 col-md-6 form-group">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}</label> <span class="text-danger">*</span>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',\App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                        </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i>{{ ___('label.update') }}</button>
                                <a href="{{ route('app_slider.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i>{{ ___('label.cancel') }} </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
@endsection()

