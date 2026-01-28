@extends('backend.partials.master')
@section('title')
{{ ___('label.role') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('roles') }}" class="breadcrumb-link">{{ ___('label.role') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site">{{ ___('label.create') }} {{ ___('label.role') }}</h4>
                    </div>

                    <form action="{{route('roles.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group col-md-12">
                                    <label class=" label-style-1" for="name">{{ ___('label.name') }}<span class="text-danger">*</span> </label>
                                    <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_role_name') }}" autocomplete="off" class="form-control input-style-1" value="{{old('name')}}" require>
                                    @error('name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label class=" label-style-1" for="status">{{ ___('label.status') }}</label>
                                    <select name="status" class="form-control input-style-1 select2">
                                        @foreach(config('site.status.default') as $key => $status)
                                        <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">

                                <table class="table border permission-table">
                                    <thead>
                                        <tr>
                                            <th>{{ ___('permissions.modules') }}</th>
                                            <th>{{ ___('permissions.permissions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission )
                                        <tr>
                                            <td>{{ ___('permissions.'.$permission->attribute) }}</td>
                                            <td>
                                                @foreach ($permission->keywords as $key=>$keyword)
                                                <div class="d-flex align-items-start permission-check-box pb-2 pt-2">
                                                    <input id="{{ $keyword }}" class="read common-key mr-2" type="checkbox" value="{{ $keyword }}" name="permissions[]" />
                                                    <label class=" label-style-1" for="{{ $keyword }}">{{ ___('permissions.'.$key) }}</label>
                                                </div>

                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                            </div>




                        </div>

                        <div class="j-create-btns">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('roles') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/roles/roles.js') }}"></script>
@endpush
