@extends('backend.partials.master')
@section('title')
{{ ___('hr_manage.leave_type') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.leave_management') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('hr_manage.leave_type') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('leave.type.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

            <input type="hidden" name="id" value="{{ $leave_type->id }}">


            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('hr_manage.leave_type') }} {{ ___('label.edit') }} </h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.name') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_title') }}" class="form-control input-style-1" name="name" value="{{ old('name',$leave_type->name) }}">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $leave_type->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                    
                                    {{-- @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $leave_type->status) == $key)> 
                                        {{ ___('common.'.  $status) }}</option>
                                    @endforeach --}}
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-lg-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',$leave_type->position) }}">
                                @error('position') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="j-create-btns ml-1">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                        <a href="{{ route('leave.type.index') }}" class="j-td-btn btn-red">
                            <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection
