@extends('backend.partials.master')
@section('title')
{{ ___('merchant.shop_list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.shops.index') }}" class="breadcrumb-link">{{ ___('merchant.shops') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">


                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('merchant.shop_list') }} </h4>
                    <a href="{{route('merchant-panel.shops.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
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
                                    <th>{{ ___('label.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($merchant_shops as $key => $shop)
                                <tr id="row_{{ $shop->id }}">
                                    <td>{{++$key}}</td>
                                    <td>
                                        {{$shop->name}}
                                        @if($shop->default_shop == \App\Enums\Status::ACTIVE)
                                        <i class="fa fa-check-circle text-success" title="{{ ___('common.default') }}"></i>
                                        @endif
                                    </td>
                                    <td>{{ $shop->contact_no}}</td>
                                    <td>{{ $shop->address}} </td>
                                    <td>{{ $shop->hub->name}}</td>
                                    <td>{{ $shop->hub->coverage->name}}</td>
                                    <td>{!! $shop->my_status !!}</td>
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if($shop->default_shop == \App\Enums\Status::INACTIVE)
                                            <a href="{{ route('shop.makeDefault',['id' => $shop->id]) }}" class="dropdown-item"> <i class="fa fa-check-circle text-success"></i> {{ ___('merchant.make_default') }}</a>
                                            @endif

                                            <a href="{{route('merchant-panel.shops.edit',$shop->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>

                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('merchant/shops/delete', {{ $shop->id }})"> <i class="fa fa-trash"></i> {{ ___('label.delete') }} </a>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($merchant_shops))
                <x-paginate-show :items="$merchant_shops" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()


@push('scripts')

@include('backend.partials.delete-ajax')

@endpush
