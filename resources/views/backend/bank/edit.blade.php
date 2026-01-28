@extends('backend.partials.master')
@section('title')
{{ ___('label.bank') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('banks.index') }}" class="breadcrumb-link">{{ ___('label.bank') }}</a></li>
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
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.edit_bank') }}</h4>
                    </div>
                    <form action="{{route('banks.update',$banks->id)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.bank_name') }} <span class="text-danger">*</span></label>
                                <input type="text" placeholder="{{ ___('label.enter_bank_name') }}" class="form-control input-style-1" name="bank_name" value="{{ old('bank_name',$banks->bank_name) }}">
                                @error('bank_name') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.position') }}</label>
                                <input type="number" placeholder="{{ ___('placeholder.position') }}" class="form-control input-style-1" name="position" value="{{ old('position',$banks->position) }}">
                                @error('position') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.status') }} <span class="text-danger">*</span></label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status', $banks->status) == $key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <p class="pt-2 text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('banks.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span> </a>
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
