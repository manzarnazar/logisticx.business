@extends('backend.partials.master')

@section('title')
{{ ___('hr_manage.leave_request') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{route('leave.request.self.index')}}" class="breadcrumb-link">{{ ___('hr_manage.leave_request') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->

    <div class="j-create-main">
        <form action="{{ route('leave-request.update',$leave_request->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="form-inputs">
                        <div class="form-input-header">
                            <h4 class="title-site">{{ ___('hr_manage.leave_request') }} {{ ___('label.edit') }}
                            </h4>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="type-select">{{ ___('hr_manage.leave_type') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="type-select" name="type_id" required>
                                    @foreach($types as $type)
                                    <option {{$leave_request->type_id == $type->id ? 'selected':''}} value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                                @error('type_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('hr_manage.leave_from') }}<span class="text-danger">*</span> </label>
                                <input type="date" readonly="readonly" name="date" placeholder="{{ ___('placeholder.select_date') }}" class="form-control input-style-1 flatpickr-range" value="{{ $leave_request->from_date . ' to ' . $leave_request->to_date }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1">{{ ___('label.attachment') }}<span class="fillable"></span></label>

                                <div class="ot_fileUploader left-side mb-3">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.attach_file') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="file">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="file_id" id="file" accept="image/jpeg, image/jpg, image/png, image/webp, file/pdf">
                                    </button>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="reason">{{ ___('hr_manage.reason') }}<span class="text-danger">*</span> </label>
                                <input id="reason" type="text" name="reason" placeholder="{{ ___('placeholder.reason') }}" class="form-control input-style-1" value="{{ old('reason',$leave_request->reason) }}">
                                @error('reason') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="j-create-btns">
                <div class="drp-btns">
                    <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                    <a href="{{ route('leave.request.self.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                </div>
            </div>
        </form>
    </div>


</div>
@endsection
