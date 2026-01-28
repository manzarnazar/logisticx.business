@extends('backend.partials.master')
@section('title')
{{ ___('hub.title') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('hubs.index') }}" class="breadcrumb-link">{{ ___('label.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="card">
        <div class="card-body">

            <div class="form-input-header">
                <h4 class="title-site"> {{ ___('label.create_hub') }}</h4>
            </div>

            <form action="{{route('hubs.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                @csrf

                <div class="form-row">
                    <div class="col-lg-6 col-12 form-group">
                        <label class="label-style-1" for="name">{{ ___('label.name')}}<span class="text-danger">*</span> </label>
                        <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{old('name')}}" @required(true) autocomplete="off">
                        @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-lg-6 col-12 form-group">
                        <label class=" label-style-1" for="phone">{{ ___('label.phone')}}<span class="text-danger">*</span> </label>
                        <input id="phone" type="tel" name="phone" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_phone') }}" class="form-control input-style-1" value="{{old('phone')}}" @required(true) autocomplete="off">
                        @error('phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>
                    <div class="col-lg-6 form-group">
                        <label class=" label-style-1" for="coverage">{{ ___('menus.coverage') }} Area <span class="text-danger">*</span> </label>
                        <select name="coverage" id="coverage" class="form-control input-style-1 select2">
                            <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }}</option>

                            @foreach($coverages as $coverage)

                            <option value="{{ $coverage->id}}" @selected(old('coverage')==$coverage->id)> {{ $coverage->name }}</option>

                            <x-coverage-child :coverage="$coverage" name="coverage" />

                            @endforeach

                        </select>
                        @error('coverage') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-lg-6 form-group">
                        <label class=" label-style-1" for="status">{{ ___('label.status')}}<span class="text-danger">*</span> </label>
                        <select name="status" class="form-control input-style-1 select2">
                            @foreach(config('site.status.default') as $key => $status)
                            <option value="{{ $key }}" @selected(old('status',\App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                            @endforeach
                        </select>
                        @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>


                    <div class="col-lg-6 col-12 form-group">
                        <label class=" label-style-1" for="address">{{ ___('label.address')}}<span class="text-danger">*</span> </label>
                        <textarea name="address" id="address" class="form-control input-style-1" rows="4" placeholder="{{ ___('placeholder.address') }}">{{ old('address')  }}</textarea>
                        @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="j-create-btns mt-2">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <a href="{{ route('hubs.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection()
