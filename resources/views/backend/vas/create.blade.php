@extends('backend.partials.master')
@section('title')
{{ ___('charges.vas') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('charges.charges')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('vas') }}" class="breadcrumb-link">{{ ___('charges.vas') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="card">
        <div class="form-input-header">
            <h4 class="title-site"> {{ ___('label.create')}} {{ ___('charges.vas') }}</h4>
        </div>

        <div class="card-body">
            <form action="{{route('vas.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                @csrf

                <div class="form-row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="label-style-1" for="name">{{___('label.name')}}</label> <span class="text-danger small">*</span>
                            <input class="form-control input-style-1" id="name" type="text" name="name" value="{{old('name')}}" placeholder="{{ ___('placeholder.enter_VAS_name') }}" autocomplete="off">
                            @error('name') <span class="text-danger small"> {{$message}}</span> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="label-style-1" for="price">{{___('label.Price')}}</label> <span class="text-danger small">*</span>
                            <input type="number" step="any" class="form-control input-style-1" id="price" name="price" value="{{ old('price') }}" placeholder="{{ ___('placeholder.enter_price') }}" autocomplete="off">
                            @error('price') <span class="text-danger small"> {{$message}}</span> @enderror
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label class="label-style-1" for="position">{{___('label.Position')}}</label>
                            <input type="number" class="form-control input-style-1" id="position" name="position" value="{{old('position',0) }}" placeholder="{{ ___('placeholder.enter_position') }}" autocomplete="off">
                            @error('position') <span class="text-danger small"> {{$message}}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="label-style-1" for="status">{{___('label.Status')}}</label> <span class="text-danger small">*</span>
                        <select class="form-select input-style-1 select2" name="status" id="status">
                            <option value="1" selected>{{___('label.active')}}</option>
                            <option value="0" @if(old('status')=="0" ) selected @endif>{{___('label.inactive')}}</option>
                        </select>
                        @error('status') <span class="text-danger small"> {{$message}}</span> @enderror

                    </div>
                </div>

                <div class="j-create-btns mt-2">
                    <div class="drp-btns">
                        <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                        <a href="{{ route('vas') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                    </div>
                </div>


            </form>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection
