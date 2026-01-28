@extends('backend.partials.master')
@section('title')
{{ ___('label.user') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('label.edit_user') }}</h4>
                    </div>
                    <form action="{{route('users.update')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @if (isset($user))
                        @method('PUT')
                        @endif
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ ___('placeholder.name') }}" autocomplete="off" class="form-control input-style-1" value="{{$user->name}}" require>
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="mobile">{{ ___('label.phone') }}<span class="text-danger">*</span> </label>
                                <input id="mobile" type="number" name="mobile" data-parsley-trigger="change" placeholder="{{ ___('placeholder.mobile') }}" autocomplete="off" class="form-control input-style-1" value="{{$user->mobile}}" require>
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="address">{{ ___('label.address') }}<span class="text-danger">*</span> </label>
                                <input id="address" type="text" name="address" data-parsley-trigger="change" placeholder="{{ ___('placeholder.address') }}" autocomplete="off" class="form-control input-style-1" value="{{$user->address}}" require>
                                @error('address') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @if($user->id != 1)
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="designation-select">{{ ___('label.designation') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="designation-select" name="designation_id" required>
                                    <option></option>
                                    @foreach($designations as $designation)
                                    <option {{$user->designation_id == $designation->id ? 'selected':''}} value="{{$designation->id}}">{{$designation->title}}</option>
                                    @endforeach
                                </select>
                                @error('designation_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="department-select">{{ ___('label.department') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1 select2" id="department-select" name="department_id" required>
                                    <option></option>
                                    @foreach($departments as $department)
                                    <option {{$user->department_id == $department->id ? 'selected':''}} value="{{$department->id}}">{{$department->title}}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="input-select">{{ ___('label.role') }}<span class="text-danger">*</span> </label>
                                <select class="form-control input-style-1  select2" id="input-select" name="role_id" required>
                                    <option></option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->id}}" {{ (old('role_id',$user->role_id) == $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="status">{{ ___('label.status') }}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1 select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',$user->status) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @endif

                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="email">{{ ___('label.email') }}<span class="text-danger">*</span> </label>
                                <input id="email" type="text" name="email" data-parsley-trigger="change" placeholder="{{ ___('placeholder.email') }}" autocomplete="off" class="form-control input-style-1" value="{{$user->email}}" require>
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="password">{{ ___('label.password') }}</label>
                                <input id="password" type="password" name="password" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_password') }}" autocomplete="off" class="form-control input-style-1">
                                @error('password') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @if($user->id != 1)
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="nid_number">{{ ___('label.nid') }}</label>
                                <input id="nid_number" type="number" name="nid_number" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_nid_number') }}" autocomplete="off" class="form-control input-style-1" value="{{$user->nid_number}}" require>
                                @error('nid_number') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="joining_date">{{ ___('label.joining_date') }}<span class="text-danger">*</span> </label>
                                <input id="joining_date" type="date" readonly="readonly" name="joining_date" autocomplete="off" class="form-control input-style-1 flatpickr" value="{{$user->joining_date}}" require>
                                @error('joining_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="hub-select">{{ ___('label.hub') }}</label>
                                <select class="form-control input-style-1 select2" id="hub-select" name="hub_id">
                                    <option value="">None</option>
                                    @foreach($hubs as $hub)
                                    <option {{$user->hub_id == $hub->id ? 'selected':''}} value="{{$hub->id}}">{{$hub->name}}</option>
                                    @endforeach
                                </select>
                                @error('hub_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @endif
                            <div class="form-group col-md-6">
                                <label class=" label-style-1" for="input-select">{{ ___('label.salary') }}</label>
                                <input type="number" class="form-control input-style-1  " placeholder="{{ ___('common.title') }}" value="{{ $user->salary }}" name="salary" />
                                @error('salary') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="label-style-1">{{ ___('label.image') }}<span class="fillable"></span></label>
                                <div class="ot_fileUploader left-side mb-3">
                                    <img src="{{getImage(@$user->upload, 'original','default-image-40x40.png')}}" alt=" " class="rounded">
                                    <input class="form-control input-style-1 placeholder" type="text" placeholder="{{ ___('label.image') }}" readonly>
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
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('users') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
