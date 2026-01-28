@extends('backend.partials.master')
@section('title')
{{ ___('common.title') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('push-notification.index') }}" class="breadcrumb-link">{{ ___('common.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('common.create_push_notification') }} </h4>
                    </div>
                    <form action="{{route('push-notification.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="title">{{ ___('label.title') }}<span class="text-danger">*</span> </label>
                                <input id="title" type="text" name="title" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_title') }}" autocomplete="off" class="form-control input-style-1  @error('title') is-invalid @enderror" value="{{ old('title') }}" require>
                                @error('title')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="type">{{ ___('label.type') }}<span class="text-danger">*</span> </label>
                                <select name="type" id="type" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('type',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>


                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.file') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="summernote">{{ ___('label.description') }}<span class="text-danger">*</span> </label>
                                <textarea class="form-control input-style-1 summernote" name="description" id="summernote" rows="8"></textarea>
                                @error('description') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                        </div>
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('push-notification.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }} </span></a>
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
