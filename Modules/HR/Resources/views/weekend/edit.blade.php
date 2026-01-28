@extends('backend.partials.master')
@section('title')
{{ ___('label.weekend') }} {{ ___('label.edit') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.weekend') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active"> {{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6  col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.edit') .' ' .___('label.weekend') }} </h4>
                    </div>

                    <form action="{{ route('weekend.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="id" value="{{$day->id}}">

                        <div class="form-group  ">
                            <label class="label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                            <input id="name" type="text" name="name" placeholder="{{ ___('label.name') }}" class="form-control input-style-1 " value="{{ old('name',  @$day->name) }}">
                            @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group w-100 ">
                            <label class="label-style-1" for="is_weekend">{{ ___('label.weekend') }}<span class="text-danger">*</span> </label>
                            <select name="is_weekend" class="form-control input-style-1  select2">
                                <option></option>
                                <option value="0" @selected(old('is_weekend',$day->is_weekend) == 0) >{{ ___('label.no') }}</option>
                                <option value="1" @selected(old('is_weekend',$day->is_weekend) == 1) >{{ ___('label.yes') }}</option>
                            </select>
                            @error('is_weekend') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group w-100">
                            <label class="label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                            <select name="status" class="form-control input-style-1  select2">
                                @foreach(config('site.status.default') as $key => $status)
                                <option value="{{ $key }}" @selected(old('status', $day->status)==$key)>{{ ___('common.'.  $status) }}</option>
                                @endforeach
                            </select>
                            @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                        </div>


                        <div class="j-create-btns mt-4">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('weekend.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
