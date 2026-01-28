@extends('backend.partials.master')
@section('title')
{{ ___('fraud.title') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.fraud.index') }}" class="breadcrumb-link">{{ ___('fraud.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
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
                    <h2 class="pageheader-title">{{ ___('fraud.edit_fraud') }}</h2>
                    <form action="{{route('merchant-panel.fraud.update',['id'=>$fraud->id])}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @if (isset($fraud))
                        @method('PUT')
                        @endif
                        <div class="form-row">

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="phone">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                                <input id="phone" type="text" name="phone" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_phone') }}" autocomplete="off" class="form-control input-style-1" value="{{old('phone',$fraud->phone)}}" require>
                                @error('phone')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ ___('placeholder.name') }}" autocomplete="off" class="form-control input-style-1" value="{{old('name',$fraud->name)}}" require>
                                @error('name')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="tracking_id">{{ ___('label.track_id') }}</label>
                                <input id="tracking_id" type="text" name="tracking_id" placeholder="{{ ___('placeholder.enter_tracking_id') }}" autocomplete="off" class="form-control input-style-1" value="{{old('tracking_id',$fraud->tracking_id)}}">
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label class="label-style-1" for="details">{{ ___('label.details') }}<span class="text-danger">*</span> </label>
                                <textarea name="details" id="details" class="form-control input-style-1" rows="6">{{old('details',$fraud->details)}}</textarea>
                            </div>
                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('merchant-panel.fraud.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
