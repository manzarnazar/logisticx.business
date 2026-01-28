@extends('backend.partials.master')
@section('title')
{{ ___('charges.product_category') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('charges.charges')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('productCategory') }}" class="breadcrumb-link">{{ ___('charges.product_category') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- data table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">

                <div class="card-header mb-4">
                    <h4 class="title-site">{{ ___('charges.product_category') }}</h4>
                    @if(hasPermission('product_category_create') )
                    <a href="{{route('productCategory.create')}}" class="j-td-btn"><img src="{{ asset('backend/icons/icon/plus-white.png') }}" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span></a>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name') }}</th>
                                    <th>{{ ___('label.Position') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if ( hasPermission('product_category_update') || hasPermission('product_category_delete') )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $key => $category)
                                <tr id="row_{{ $category->id }}">
                                    <td>{{$key + 1}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$category->position}}</td>
                                    <td>{!! $category->my_status !!}</td>

                                    {{-- links for actions --}}
                                    @if ( hasPermission('product_category_update') || hasPermission('product_category_delete') )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if ( hasPermission('product_category_update') )
                                            <a href="{{route('productCategory.edit',$category->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if ( hasPermission('product_category_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/charges/product-category/delete', {{$category->id}})"><i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}</a>
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
                </div>
                <!-- pagination component -->
                @if(count($categories))
                <x-paginate-show :items="$categories" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
