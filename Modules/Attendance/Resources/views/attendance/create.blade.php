@extends('backend.partials.master')

@section('title')
{{ ___('label.attendance') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}" class="breadcrumb-link">{{ ___('label.attendance') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('attendance.store') }}" method="post">
            @csrf
            <div class="form-inputs">
                <div class="form-input-header">
                    <h4 class="name-site">{{ ___('label.attendance') }} </h4>
                </div>

                <div class="form-row">

                    <div class="form-group col-sm-6 col-md-3">
                        <label class=" label-style-1" for="department">{{ ___('label.department') }}<span class="text-danger">*</span> </label>
                        <select class="form-control input-style-1 select2" id="department" name="department">
                            <option></option>
                            <option value="0">{{ ___('label.select') }} {{ ___('label.department') }}</option>
                            @foreach($departments as $item)
                            <option value="{{$item->id}}" @selected(old('department')==$item->id)>{{$item->title}}</option>
                            @endforeach
                        </select>
                        @error('department') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-sm-6 col-md-3">
                        <label class=" label-style-1" for="designation">{{ ___('label.designation') }}</label>
                        <select class="form-control input-style-1 select2" id="designation" name="designation">
                            <option></option>

                            @foreach($designations as $item)
                            <option value="{{$item->id}}" @selected(old('designation')==$item->id)>{{$item->title}}</option>
                            @endforeach

                        </select>
                        @error('designation') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-sm-6 col-md-3">
                        <label class="label-style-1" for="user">{{ ___('label.user') }}</label>
                        <select id="userID" name="user" class="form-control input-style-1"  data-url="{{ route('attendance.user.search') }}" data-placeholder="{{___('placeholder.select_user') }}">
                            <option></option>
                        </select>
                        @error('userID') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group col-sm-6 col-md-3">
                        <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                        <input type="date" id="date" name="date" placeholder="{{ ___('placeholder.enter_date_range') }}" class="form-control input-style-1 flatpickr" value="{{ old('date', now()->toDateString()) }}">
                        @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div id="user_rows" data-url="{{ route('attendance.users.getWithFilter') }}">
                </div>

            </div>
            <div class="j-create-btns mt-4">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i> <span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('attendance.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i> <span>{{ ___('label.cancel') }}</span></a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')

<script src="{{ asset('backend/js/custom/attendance/create.js')}}"></script>

@endpush
