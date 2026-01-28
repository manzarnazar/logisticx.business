@extends('backend.partials.master')
@section('title')
{{ ___('label.role') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
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
                    <h4 class="title-site">{{ ___('label.role') }} {{ ___('label.list') }}</h4>
                    @if(hasPermission('role_create') )
                    <a href="{{route('roles.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name') }}</th>
                                    <th>{{ ___('label.slug') }}</th>
                                    <th>{{ ___('label.permission') }}</th>
                                    <th>{{ ___('label.status') }}</th>

                                    @if(hasPermission('role_update') == true || hasPermission('role_delete') == true)
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($roles as $role)
                                <tr id="row_{{ $role->id }}">
                                    <td>{{$i++}}</td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->slug}}</td>
                                    <td>
                                        @if(!empty($role->permissions) )
                                        <label class="bullet-badge bullet-badge-info">{{ count($role->permissions) }}</label>
                                        @endif
                                    </td>
                                    <td>{!! $role->my_status !!}</td>
                                    @if(hasPermission('role_update') == true || hasPermission('role_delete') == true )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('role_update') == true )
                                            <a href="{{route('roles.edit',$role->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if( hasPermission('role_delete') == true )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/role/delete', {{$role->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>

                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($roles))
                <x-paginate-show :items="$roles" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
    </div>
</div>
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
