@extends('backend.partials.master')
@section('title')
{{ ___('menus.coupon') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}" class="breadcrumb-link">{{ ___('menus.coupon') }}</a></li>
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
                    <div class="card-header mb-3">
                        <h4 class="title-site">{{ ___('menus.coupon') }}</h4>
                        @if(hasPermission('coupon_create'))
                        <a href="{{route('coupon.create')}}" class="j-td-btn">
                            <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                        </a>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  ">
                                <thead class="bg">
                                    <tr>
                                        <th>{{ ___('label.id') }}</th>
                                        <th>{{ ___('label.coupon') }}</th>
                                        <th>{{ ___('label.start_date') }}</th>
                                        <th>{{ ___('label.end_date') }}</th>
                                        <th>{{ ___('label.discount') }}</th>
                                        <th>{{ ___('label.type') }}</th>
                                        <th>{{ ___('label.discount_type') }}</th>
                                        <th>{{ ___('label.status') }}</th>

                                        @if(hasPermission('coupon_update') || hasPermission('coupon_delete') )
                                        <th>{{ ___('label.actions') }}</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @forelse($coupons as $coupon)
                                    <tr id="row_{{ $coupon->id }}">
                                        <td>{{$i++}}</td>
                                        <td>{{ $coupon->coupon }}</td>
                                        <td>{{dateFormat($coupon->start_date)}}</td>
                                        <td>{{dateFormat($coupon->end_date)}}</td>
                                        <td>{{$coupon->discount_text}} </td>
                                        <td>{!! $coupon->TypeBadge !!}</td>
                                        <td>{!! $coupon->DiscountTypeBadge !!}</td>
                                        <td>{!! $coupon->my_status !!}</td>
                                        @if(hasPermission('coupon_update') || hasPermission('coupon_delete') )
                                        <td>
                                            <div class="d-flex" data-toggle="dropdown">
                                                <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                            </div>
                                            <div class="dropdown-menu">

                                                @if(hasPermission('coupon_update') )
                                                <a href="{{route('coupon.edit',$coupon->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                @endif

                                                @if(hasPermission('coupon_delete') )
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('coupon/delete', {{$coupon->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                        @if(count($coupons))
                        <x-paginate-show :items="$coupons" />
                        @endif

                        <!-- pagination component -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
