@extends('backend.partials.master')

@section('title')
{{ ___('menus.coverage') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('coverage.index')}}" class="breadcrumb-link">{{ ___('menus.coverage') }}</a></li>
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

                <div class="card-header mb-4">
                    <h4 class="title-site">{{ ___('menus.coverage') }}</h4>
                    @if(hasPermission('coverage_create') )
                    <a href="{{route('coverage.create')}}" class="j-td-btn"><img src="{{ asset('backend/icons/icon/plus-white.png') }}" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span></a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name') }}</th>
                                    <th>{{ ___('label.parent') }}</th>
                                    <th>{{ ___('label.position') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    <th>{{ ___('label.actions') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coverages as $key => $coverage)
                                <tr id="row_{{ $coverage->id }}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $coverage->name }}</td>
                                    <td>{{ @$coverage->parent->name }}</td>
                                    <td>{{ $coverage->position }}</td>
                                    <td>{!! $coverage->my_status !!}</td>
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            <a href="{{route('coverage.edit',$coverage->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/coverage/delete', {{$coverage->id}})"><i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- pagination component -->
                    @if(count($coverages))
                    <x-paginate-show :items="$coverages" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
        </div>
    </div>
</div>


@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
