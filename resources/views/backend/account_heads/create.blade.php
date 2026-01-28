@extends('backend.partials.master')
@section('title')
{{ ___('account.account_heads') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('account.heads.index') }}" class="breadcrumb-link">{{ ___('account.account_heads') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
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
                        <h4 class="title-site">{{ ___('label.create')}} {{ ___('account.account_head') }}</h4>
                    </div>

                    <form action="{{route('account.heads.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="type">{{ ___('label.type') }} <span class="text-danger">*</span></label>
                                <select id="type" name="type" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.type') }}</option>
                                    @foreach(config('site.account_head') as $key => $value)
                                    <option value="{{ $key }}" @selected(old('type')==$key)>{{ ___('account.' . $value)}}</option>
                                    @endforeach
                                </select>
                                @error('type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>



                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="name">{{ ___('label.name')}} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control input-style-1" id="name" name="name" value="{{old('name')}}" placeholder="{{ ___('placeholder.enter_name')}}">
                                @error('name') <span class="text-danger small"> {{$message}}</span> @enderror
                            </div>


                            <div class="form-group col-md-6 d-block" id="accountStatus">
                                <label class="label-style-1" for="status">{{ ___('label.status')}}</label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}">{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>




                        </div>
                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('account.heads.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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

@push('scripts')
<script src="{{ asset('backend/js/custom/account/account.js') }}"></script>
@endpush
