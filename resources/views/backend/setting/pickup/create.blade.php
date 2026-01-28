@extends('backend.partials.master')
@section('title')
{{ ___('menus.pickup_slot') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('pickup.index') }}" class="breadcrumb-link">{{ ___('menus.pickup_slot') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.add') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->


    <div class="j-create-main">
        <form action="{{route('pickup.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('label.add') }} {{ ___('menus.pickup_slot') }}
                            </h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="title">{{ ___('Title') }}<span class="text-danger">*</span> </label>
                                <input type="text" class="form-control input-style-1 " id="title" name="title" value="{{ old('title') }}" placeholder="{{ ___('placeholder.pickup_slot_title') }}" />
                                @error('title') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="position">{{ ___('label.position') }}</label>
                                <input id="position" type="number" name="position" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1 " value="{{old('position',0)}}" />
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="start_time">{{ ___('label.start_time') }} <span class="text-danger">*</span> </label>
                                <input id="start_time" type="time" name="start_time" placeholder="{{ ___('placeholder.start_time') }}" class="form-control input-style-1" value="{{old('start_time')}}" />
                                @error('start_time') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="end_time"> {{ ___('label.end_time') }}<span class="text-danger">*</span> </label>
                                <input id="end_time" type="time" name="end_time" placeholder="{{ ___('placeholder.end_time') }}" class="form-control input-style-1 " value="{{old('end_time')}}" />
                                @error('end_time') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>


                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
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
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('pickup.index') }}" class="j-td-btn btn-red">
                        <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span>
                    </a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection()
