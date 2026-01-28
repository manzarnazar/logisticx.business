@extends('backend.partials.master')
@section('title')
{{ ___('menus.profile') }} {{ ___('menus.change_password') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('dashboard.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ url()->previous() }}" class="breadcrumb-link">{{ ___('menus.profile') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('menus.change_password')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">

        <!-- card form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="pageheader-title">{{ ___('menus.change_password') }}</h2>
                    <form action="{{route('merchant-profile.password.update',$merchat->user->id)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="old_password">{{ ___('label.old_password') }}</label>
                                    <input id="old_password" type="password" name="old_password" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_old_password' ) }}" autocomplete="off" class="form-control" value="{{old('old_password')}}" require>
                                    @error('old_password')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="new_password">{{ ___('label.new_password') }}</label>
                                    <input id="new_password" type="password" name="new_password" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_new_password' ) }}" autocomplete="off" class="form-control" value="{{old('new_password')}}" require>
                                    @error('new_password')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="confirm_password">{{ ___('label.confirm_password') }}</label>
                                    <input id="confirm_password" type="password" name="confirm_password" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_confirm_password' ) }}" autocomplete="off" value="{{old('confirm_password')}}" class="form-control" require>
                                    @error('confirm_password')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-space btn-primary"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ url()->previous() }}" class="btn btn-space btn-secondary"><i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end card form -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
