@extends('backend.partials.master')
@section('title')
{{ ___('menus.profile') }} {{ ___('menus.update') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.update') }}</a></li>
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
                    <h2 class="pageheader-title"><i class="fa-solid fa-floppy-disk"></i>{{ ___('label.update') }} {{ ___('menus.profile') }}</h2>
                    <form action="{{route('merchant-profile.update',$merchant->user->id)}}" method="POST" enctype="multipart/form-data" id="basicform">

                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ ___('label.name') }}</label>
                                    <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="Enter name" autocomplete="off" class="form-control" value="{{$merchant->user->name}}" require>
                                    @error('name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ ___('label.email') }}</label>
                                    <input id="email" type="text" name="email" data-parsley-trigger="change" placeholder="Enter email" autocomplete="off" class="form-control" value="{{$merchant->user->email}}" require>
                                    @error('email')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="mobile">{{ ___('label.mobile') }}</label>
                                    <input id="mobile" type="text" name="mobile" data-parsley-trigger="change" placeholder="Enter mobile" autocomplete="off" class="form-control" value="{{$merchant->user->mobile}}" require>
                                    @error('mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="business_name">{{ ___('label.business_name') }}</label>
                                    <input id="business_name" type="text" name="business_name" data-parsley-trigger="change" placeholder="Enter business name" autocomplete="off" class="form-control" value="{{$merchant->business_name}}" require>
                                    @error('business_name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">{{ ___('label.address') }}</label>
                                    <input id="address" type="text" name="address" data-parsley-trigger="change" placeholder="Enter Address" autocomplete="off" class="form-control" value="{{$merchant->address}}" require>
                                    @error('address')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="coverage">{{ ___('menus.coverage') }} Area <span class="text-danger">*</span> </label>
                                    <select name="coverage" id="coverage" class="form-control select2">
                                        <option value="" @selected(true)>{{ ___('label.select') }}</option>

                                        @foreach($coverages as $coverage)

                                        <option value="{{ $coverage->id}}" @selected(old('coverage',$merchant->coverage_id)==$coverage->id)> {{ $coverage->name }}</option>

                                        <x-coverage-child :coverage="$coverage" name="coverage" :old="$merchant->coverage_id" />

                                        @endforeach

                                    </select>
                                    @error('coverage') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                                </div>


                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <label for="image_id">{{ ___('label.image') }}</label>
                                            <input id="image_id" type="file" name="image_id" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3 mt-3 mt-md-0">
                                            <img src="{{ getImage($merchant->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded" width="70" height="70">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <label for="nid">{{ ___('label.nid') }}</label>
                                            <input id="nid" type="file" name="nid" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3 pt-4">
                                            <img src="{{$merchant->nid}}" alt="user" class="rounded" width="70" height="70">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12 col-md-9">
                                            <label for="trade_license">{{ ___('label.trade_license') }}</label>
                                            <input id="trade_license" type="file" name="trade_license" data-parsley-trigger="change" autocomplete="off" class="form-control">
                                        </div>
                                        <div class="col-12 col-md-3 pt-4">
                                            <img src="{{$merchant->trade}}" alt="user" class="rounded" width="70" height="70">
                                        </div>
                                    </div>
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
