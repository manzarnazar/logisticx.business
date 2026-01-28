@extends('backend.partials.master')
@section('title')
{{ ___('label.title') }} {{ ___('permissions.permissions') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('permissions.permissions') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.title') }}</h4>
                </div>

                <div class="card-body">
                    <form action="{{route('users.permissions.update',['id'=>$user->id])}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="">
                                    <table class="table border permission-table">
                                        <thead class="bg">
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
                                                    <div class="row align-items-start permission-check-box py-2">
                                                        <input id="{{ $keyword }}" class="read common-key mr-2" type="checkbox" value="{{ $keyword }}" name="permissions[]" @if(in_array($keyword,$user->permissions)) checked @endif />
                                                        <label for="{{ $keyword }}">{{ ___('permissions.'.$key) }}</label>
                                                    </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                </div>
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

@push('scripts')
<script src="{{ asset('backend/js/custom/roles/roles.js') }}"></script>
@endpush
