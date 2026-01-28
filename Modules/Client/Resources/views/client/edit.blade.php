@extends('backend.partials.master')
@section('title')
{{ ___('client') }} {{ ___('edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('client.index') }}" class="breadcrumb-link">{{ ___('label.client') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('client.update',[$client->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('label.client') }}</h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-lg-6 ">
                                <label class="label-style-1">{{ ___('label.name') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_name') }}" class="form-control input-style-1" name="name" value="{{ old('name',$client->name) }}">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                             <div class="form-group col-lg-6 ">
                                <label class="label-style-1">{{ ___('label.title') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.title') }}" class="form-control input-style-1" name="title" value="{{ old('title',$client->title) }}">
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label class="label-style-1">{{ ___('label.facebook_id') }} <span class="text-danger">*</span></label>
                                <input type="url" placeholder="{{ ___('label.facebook_id') }}" class="form-control input-style-1" name="facebook_id" value="{{ old('facebook_id',$client->name) }}">
                                @error('facebook_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label class="label-style-1">{{ ___('label.twitter_id') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.twitter_id') }}" class="form-control input-style-1" name="twitter_id" value="{{ old('twitter_id',$client->twitter_id) }}">
                                @error('twitter_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-lg-6 ">
                                <label class="label-style-1">{{ ___('label.linkedIn_id') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.linkedIn_id') }}" class="form-control input-style-1" name="linkedIn_id" value="{{ old('linkedIn_id',$client->linkedIn_id) }}">
                                @error('linkedIn_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.logo') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{ getImage($client->upload, 'original','default-image-40x40.png') }}">

                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="fileBrouse">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="logo" id="fileBrouse" accept="image/jpeg, image/jpg, image/png, image/webp">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',$client->position) }}">
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $client->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i> <span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('client.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark"></i> <span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>

</div>

@endsection
