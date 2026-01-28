@extends('backend.partials.master')
@section('title')
{{ ___('label.team') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('team.index') }}" class="breadcrumb-link">{{ ___('label.team') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('team.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.create') }} {{ ___('label.team') }}
                            </h4>
                        </div>
                        <div class="form-row">


                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.user') }} <span class="text-danger">*</span></label>
                                <select name="user" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('label.select')}} {{ ___('label.user') }} </option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" @if(old('user')==$user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.position') }}</label>
                                    <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="0">
                                    @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.facebook') }} </label>
                                    <input type="text" placeholder="{{ ___('label.facebook') }}" class="form-control input-style-1" name="facebook" value="{{ old('facebook') }}">
                                    @error('facebook') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.linkedin') }} </label>
                                    <input type="text" placeholder="{{ ___('label.linkedin') }}" class="form-control input-style-1" name="linkedin" value="{{ old('linkedin') }}">
                                    @error('linkedin') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.twitter') }} </label>
                                    <input type="text" placeholder="{{ ___('label.twitter') }}" class="form-control input-style-1" name="twitter" value="{{ old('twitter') }}">
                                    @error('twitter') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">

                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value=" {{ $key }}" @selected(old('status', \App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                    {{-- <option value="{{ \App\Enums\Status::ACTIVE }}" selected>{{ ___('active')}} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}">{{ ___('inactive')}} </option> --}}

                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('team.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection
