@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.delivery_charge') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('merchant.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('menus.merchants') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.deliveryCharge.index',$merchant_id) }}" class="breadcrumb-link">{{ ___('merchant.delivery_charge') }}</a></li>
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
                    <h4 class="title-site">{{ ___('merchant.delivery_charge') }} {{ ___('label.list') }}</h4>
                    @if(hasPermission('merchant_delivery_charge_create') == true )
                    <a href="{{ route('merchant.deliveryCharge.create',$merchant_id) }}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>

                <div class="card-body">
                    <table class="table  ">
                        <thead class="bg">
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('charges.product') }}</th>
                                <th>{{ ___('charges.service') }}</th>
                                <th>{{ ___('charges.area') }}</th>
                                <th>{{ ___('charges.time') }}</th>
                                <th>{{ ___('charges.charges') }}</th>
                                <th>{{ ___('label.status') }}</th>
                                @if(hasPermission('merchant_delivery_charge_update') == true || hasPermission('merchant_delivery_charge_delete') == true)
                                <th>{{ ___('label.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($charges as $key => $charge)

                            <tr id="row_{{ $charge->id }}">
                                <td>{{ $key + 1}}</td>
                                <td>{{$charge->productCategory->name}}</td>
                                <td>{{$charge->serviceType->name}}</td>
                                <td>{{ ___(('charges.'.$charge->area)) }} </td>
                                <td>{{$charge->delivery_time}} {{ ___('label.hour') }} </td>

                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span> {{ ___('label.regular') }} : </span> <span> {{@settings('currency') .  $charge->charge}} </span>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <span> {{ ___('label.additional') }} : </span> <span> {{@settings('currency') .  $charge->additional_charge}} </span>
                                    </div>
                                </td>

                                <td>{!! $charge->my_status !!}</td>

                                {{-- links for actions --}}
                                @if( hasPermission('merchant_delivery_charge_update') == true || hasPermission('merchant_delivery_charge_delete') == true )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if( hasPermission('merchant_delivery_charge_update') == true )
                                        <a href="{{route('merchant.deliveryCharge.edit',[$merchant_id,$charge->id])}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif

                                        @if( hasPermission('merchant_delivery_charge_delete') == true )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/merchant/$charge->merchant_id/delivery-charge/delete', {{$charge->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                        @endif
                                    </div>
                                </td>
                                @endif

                            </tr>
                            @empty
                            <x-nodata-found :colspan="8" />
                            @endforelse
                        </tbody>
                    </table>
                    <!-- pagination component -->
                    @if(count($charges))
                    <x-paginate-show :items="$charges" />
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
