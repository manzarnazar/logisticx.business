@extends('backend.partials.master')
@section('title')
{{ ___('menus.create_user') }}
@endsection
@section('maincontent')
<div class="container-fluid  dashboard-content">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.user_role')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users') }}" class="breadcrumb-link">{{ ___('label.user') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('menus.create_user') }}</h4>
                    </div>
                    <form action="{{route('users.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input id="name" type="text" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1 " value="{{ old('name') }}">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="mobile">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                                <input id="mobile" type="number" name="mobile" placeholder="{{ ___('placeholder.mobile') }}" class="form-control input-style-1 " value="{{ old('mobile') }}">
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="address">{{ ___('label.address') }}<span class="text-danger">*</span> </label>
                                <input id="address" type="text" name="address" placeholder="{{ ___('placeholder.address') }}" class="form-control input-style-1 " value="{{ old('address') }}">
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="designation_id">{{ ___('label.designation') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="designation_id" name="designation_id" data-placeholder="Select {{ ___('label.designation') }}" d>
                                    <option></option>
                                    @foreach($designations as $designation)
                                    <option value="{{$designation->id}}" @selected(old('designation_id')==$designation->id)>{{$designation->title}}</option>
                                    @endforeach
                                </select>
                                @error('designation_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1">{{ ___('label.department') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1  select2" name="department_id" data-placeholder="Select {{ ___('label.department') }}" d>
                                    <option></option>
                                    @foreach($departments as $department)
                                    <option value="{{$department->id}}" @selected(old('department_id')==$department->id)>{{$department->title}}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1">{{ ___('label.role') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1  select2" name="role_id" data-placeholder="Select {{ ___('label.role') }}" d>
                                    <option></option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ (old('role_id') == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}</label>
                                <select name="status" id="status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('status',\App\Enums\Status::ACTIVE)==$key)>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="email">{{ ___('label.email') }}<span class="text-danger">*</span> </label>
                                <input id="email" type="email" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1 " value="{{ old('email') }}">
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="password">{{ ___('label.password') }}<span class="text-danger">*</span> </label>
                                <input id="password" type="password" name="password" placeholder="{{ ___('placeholder.enter_password') }}" class="form-control input-style-1 " value="{{ old('password') }}">
                                @error('password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="nid_number">{{ ___('label.nid') }}</label>
                                <input id="nid_number" type="number" name="nid_number" placeholder="{{ ___('placeholder.enter_nid_number') }}" class="form-control input-style-1 " value="{{ old('nid_number') }}">
                                @error('nid_number') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="joining_date">{{ ___('label.joining_date') }}<span class="text-danger">*</span> </label>
                                <input id="joining_date" type="date" readonly="readonly" data-toggle="datepicker" name="joining_date" placeholder="yyyy-mm-dd" class="form-control input-style-1 " value="{{ old('joining_date',date('Y-m-d')) }}">
                                @error('joining_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1">{{ ___('label.hub') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" name="hub_id" data-placeholder="{{ ___('placeholder.select_hub') }}">
                                    <option></option>
                                    @foreach($hubs as $hub)
                                    <option value="{{$hub->id}}" @selected(old('hub_id')==$hub->id)>{{$hub->name}}</option>
                                    @endforeach
                                </select>
                                @error('hub_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class=" label-style-1">{{ ___('label.salary') }}</label>
                                <input type="number" step="any" class="form-control input-style-1 " value="{{ old('salary',0) }}" placeholder="{{ ___('common.title') }}" name="salary" />
                                @error('salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            {{-- new image  --}}

                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{ getImage(null) }}" alt="">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('placeholder.no_file_chosen') }}" readonly>
                                    <button class="primary-btn-small-input" type="button">
                                        <label class="j-td-btn" for="image">{{ ___('label.browse') }}</label>
                                        <input type="file" class="d-none form-control" name="image" id="image" accept="image/jpg, image/jpeg, image/png">
                                    </button>
                                </div>
                                @error('image') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('users') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection()
