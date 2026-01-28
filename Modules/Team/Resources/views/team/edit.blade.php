@extends('backend.partials.master')
@section('title')
{{ ___('label.team') }} {{ ___('label.update') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->


    <div class="j-create-main">
        <form action="{{ route('team.update',[$team->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('label.team') }}</h4>
                        </div>
                        <div class="form-row">


                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.user') }} <span class="text-danger">*</span></label>
                                <select name="user" class="form-control input-style-1 select2">
                                    <option selected disabled> {{ ___('label.select_user') }} </option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}" @if(old('user',$team->user_id) == $user->id) selected @endif >{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.position') }} </label>
                                    <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',$team->position) }}">
                                    @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.facebook') }}</label>
                                    <input type="text" placeholder="{{ ___('label.enter') ." ". ___('label.facebook') }}" class="form-control input-style-1" name="facebook" value="{{ old('facebook',$team->facebook) }}">
                                    @error('facebook') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.twitter') }}</label>
                                    <input type="text" placeholder="{{ ___('label.enter') ." ". ___('label.twitter') }}" class="form-control input-style-1" name="twitter" value="{{ old('twitter',$team->twitter) }}">
                                    @error('twitter') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group ">
                                    <label class="label-style-1">{{ ___('label.linkedin') }}</label>
                                    <input type="text" placeholder="{{ ___('label.enter') ." ". ___('label.linkedin') }}" class="form-control input-style-1" name="linkedin" value="{{ old('linkedin',$team->linkedin) }}">
                                    @error('linkedin') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>
                            </div>


                            <div class="form-group col-12 col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    <option value="{{ \App\Enums\Status::ACTIVE }}" @if(old('status',$team->status) == \App\Enums\Status::ACTIVE) selected @endif>{{ ___('label.active')}} </option>
                                    <option value="{{ \App\Enums\Status::INACTIVE }}" @if(old('status',$team->status) == \App\Enums\Status::INACTIVE) selected @endif>{{ ___('label.inactive')}} </option>
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="j-create-btns ml-1">
                                <div class="drp-btns">
                                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                                    {{-- <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button> --}}
                                    <a href="{{ route('team.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </form>

    </div>

</div>
@endsection
