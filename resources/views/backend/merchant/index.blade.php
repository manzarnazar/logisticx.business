@extends('backend.partials.master')
@section('title')
{{ ___('menus.merchants') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
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


            <div class="j-parcel-main j-parcel-res">
                <div class="card">

                    <div class="  card-header mb-3">

                        <h4 class="title-site">{{ ___('menus.merchants') }}</h4>

                        @if(hasPermission('merchant_create') == true )
                        <a href="{{route('merchant.create')}}" class="j-td-btn">
                            <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                        </a>
                        @endif

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('label.user_info') }}</th>
                                        <th>{{ ___('label.business_info') }}</th>
                                        <th>{{ ___('label.hub') }}</th>
                                        <th>{{ ___('label.coverage') }}</th>
                                        <th>{{ ___('label.phone') }}</th>
                                        <th>{{ ___('label.status') }}</th>
                                        @if(
                                        hasPermission('merchant_view') == true ||
                                        hasPermission('merchant_update') == true ||
                                        hasPermission('merchant_delete') == true
                                        )
                                        <th>{{ ___('label.actions') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse($merchants as $key => $merchant)

                                    <tr id="row_{{ $merchant->id }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <a href="{{route('merchant.view',$merchant->id)}}">
                                                <div class="d-flex">
                                                    <div class="pr-3">
                                                        <img src="{{ getImage($merchant->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded" width="40" height="40">
                                                    </div>
                                                    <div>
                                                        <strong>{{ ___('label.name') }} : {{$merchant->user->name}}</strong><br>
                                                        <span>{{ ___('label.email') }} : {{$merchant->user->email}}</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('merchant.view',$merchant->id)}}">
                                                <strong>{{ ___('label.name') }} : {{@$merchant->business_name}}</strong> <br>
                                                <span>{{ ___('label.unique_id') }} : {{@$merchant->merchant_unique_id}}</span>
                                            </a>
                                        </td>
                                        <td> {{@$merchant->user->hub->name}} </td>
                                        <td>{{@$merchant->coverage->name}}</td>
                                        <td>{{@$merchant->user->mobile}}</td>
                                        <td>{!! $merchant->user->my_status !!}</td>
                                        @if(
                                        hasPermission('merchant_view') == true ||
                                        hasPermission('merchant_update') == true ||
                                        hasPermission('merchant_delete') == true
                                        )
                                        <td>
                                            <div class="d-flex" data-toggle="dropdown">
                                                <a class="p-2" href="javascript:void()">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                            </div>
                                            <div class="dropdown-menu">
                                                @if( hasPermission('merchant_view') == true )
                                                <a href="{{route('merchant.view',$merchant->id)}}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>
                                                @endif
                                                @if( hasPermission('merchant_update') == true )
                                                <a href="{{route('merchant.edit',$merchant->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                @endif
                                                @if( hasPermission('merchant_delete') == true )
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/merchant/delete', {{$merchant->id}})">
                                                    <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                                </a>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </tr>

                                    @empty
                                    <x-nodata-found :colspan="9" />
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- pagination component -->
                        @if(count($merchants))
                        <x-paginate-show :items="$merchants" />
                        @endif

                        <!-- pagination component -->
                    </div>
                </div>
            </div>

        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

<!-- js  -->
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
