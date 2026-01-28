@extends('backend.partials.master')

@section('title')
{{ ___('label.shop_list') }} | {{ ___('menus.merchant') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.shop') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4 col-lg-12 col-xl-3">
            <x-backend.merchant.view-card :merchantId="$merchant_id" />
        </div>

        <div class="col-md-8 col-lg-12 col-xl-9">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('label.shop_list') }}</h4>
                    @if(hasPermission('merchant_shop_create') == true )
                    <a href="{{ route('merchant.shops.create',$merchant_id) }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <table class="table  ">
                        <thead class="bg">
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('label.name') }}</th>
                                <th>{{ ___('label.contact') }}</th>
                                <th>{{ ___('label.address') }}</th>
                                <th>{{ ___('label.hub') }}</th>
                                <th>{{ ___('label.coverage') }}</th>
                                <th>{{ ___('label.status') }}</th>
                                @if(hasPermission('merchant_shop_update') || hasPermission('merchant_shop_delete') )
                                <th>{{ ___('label.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($shops as $key => $shop)

                            <tr id="row_{{ $shop->id }}">
                                <td>{{++$key}}</td>
                                <td>
                                    {{$shop->name}}
                                    @if($shop->default_shop == \App\Enums\Status::ACTIVE) <i class="fa fa-check-circle text-success" title="{{ ___('merchant.default_shop') }}"></i> @endif
                                </td>
                                <td>{{$shop->contact_no}}</td>
                                <td>{{$shop->address}}</td>
                                <td>{{@$shop->hub->name}}</td>
                                <td>{{@$shop->coverage->name}}</td>
                                <td> {!! $shop->my_status !!}</td>

                                @if(hasPermission('merchant_shop_update') || hasPermission('merchant_shop_delete') )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">

                                        @if($shop->default_shop == \App\Enums\Status::INACTIVE)
                                        <a href="{{ route('merchant.shops.default',['merchant_id' => $shop->merchant_id,'id' => $shop->id]) }}" class="dropdown-item"> <i class="fa fa-check-circle text-success"></i> {{ ___('merchant.make_default') }}</a>
                                        @endif

                                        @if(hasPermission('merchant_shop_update') )
                                        <a href="{{route('merchant.shops.edit',$shop->id)}}" class="dropdown-item"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                        @endif

                                        @if(hasPermission('merchant_shop_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/merchant/shops/delete', {{$shop->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                    <!-- pagination component -->
                    @if(count($shops))
                    <x-paginate-show :items="$shops" />
                    @endif
                    <!-- end pagination component -->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection()

@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
