@extends('backend.partials.master')

@section('title')
{{ ___('hr_manage.all_leave_request') }} {{ ___('label.create') }}
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
                            <li class="breadcrumb-item"><a href="{{route('all-leave-request.index')}}" class="breadcrumb-link">{{ ___('hr_manage.all_leave_request') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('leave-request.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('hr_manage.leave_request') }} {{ ___('label.create') }} </h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="user">{{ ___('label.user') }}</label>
                                <select id="userID" name="user" class="form-control input-style-1" data-url="{{ route('user.search') }}" data-placeholder="{{___('placeholder.select_user')}}">
                                    <option></option>
                                </select>
                                @error('user') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1">{{ ___('hr_manage.leave_type') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1  select2" name="type_id" id="type_id" data-url="{{route('leave.request.types')}}">
                                    <option disabled selected value="0">{{ ___('placeholder.Select_User_First') }}</option>
                                </select>
                                @error('type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('hr_manage.leave_from') }}<span class="text-danger">*</span> </label>
                                <input type="date" name="date" placeholder="{{ ___('placeholder.select_date') }}" class="form-control input-style-1 flatpickr-range" value="{{old('date',date('Y-m-d'))}}" required>
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.attachment') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="file_id" id="file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="reason">{{ ___('hr_manage.reason') }}<span class="text-danger">*</span> </label>
                                <textarea name="reason" id="reason" placeholder="{{ ___('placeholder.reason') }}" class="form-control input-style-1">{{ old('reason') }}</textarea>
                                @error('reason') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk"></i><span>{{ ___('label.save') }}</span></button>
                    <a href="{{ route('all-leave-request.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark"></i><span>{{ ___('label.cancel') }}</span></a>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection

@push('scripts')

<script src="{{ asset('backend/js/custom/leave_request/leave_request.js')}}"></script>

@endpush
