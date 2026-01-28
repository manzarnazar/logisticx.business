@extends('backend.partials.master')
@section('title')
{{ ___('account.account_heads') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.account')}}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.account_heads') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.account_heads') }}</h4>
                    @if(hasPermission('account_heads_create') )
                    <a href="{{route('account.heads.create')}}" class="j-td-btn"> <img src="{{ asset('backend/icons/icon/plus-white.png') }}" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span></a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name')}}</th>
                                    <th>{{ ___('label.type')}}</th>
                                    <th>{{ ___('label.status')}}</th>
                                    @if(hasPermission('account_heads_update') || hasPermission('account_heads_delete') )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($account_heads as $key => $head)
                                <tr id="row_{{ $head->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $head->name  }}</td>
                                    <td>{!! $head->my_type !!}</td>
                                    <td>{!! $head->my_status !!}</td>
                                    @if(hasPermission('account_heads_update') || hasPermission('account_heads_delete') )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if(hasPermission('account_heads_update') && !in_array($head->id, $protectedIds))
                                            <a href="{{route('account.heads.edit',$head->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if( hasPermission('account_heads_delete') && !in_array($head->id, $protectedIds))
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/account-heads/delete', {{$head->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination component -->
                    @if(count($account_heads))
                    <x-paginate-show :items="$account_heads" />
                    @endif
                    <!-- end pagination component -->
                </div>
            </div>
        </div>
        <!-- end table  -->
    </div>
</div>
<!-- end wrapper  -->


@endsection()
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
