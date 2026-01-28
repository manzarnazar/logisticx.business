@extends('backend.partials.master')
@section('title')
{{ ___('parcel.deliveryman') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.index') }}" class="breadcrumb-link">{{ ___('parcel.deliveryman') }}</a></li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('deliveryman.filter')}}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="name">{{ ___('label.name') }}</label>
                                <input type="text" id="name" name="name" placeholder="{{ ___('placeholder.name') }}" class="form-control input-style-1" value="{{old('name', request()->name)}}">
                                @error('name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="email">{{ ___('label.email') }}</label>
                                <input type="text" id="email" name="email" placeholder="{{ ___('placeholder.email') }}" class="form-control input-style-1" value="{{old('email', request()->email)}}">
                                @error('email') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="phone">{{ ___('label.phone')}}</label> <span class="text-danger"></span>
                                <input type="text" id="phone" name="phone" placeholder="{{ ___('placeholder.phone') }}" class="form-control input-style-1" value="{{old('phone', request()->phone)}}">
                                @error('phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-lg-4 col-md-6 ">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('deliveryman.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('parcel.deliveryman') }}</h4>
                    @if(hasPermission('delivery_man_create'))
                    <a href="{{route('deliveryman.create')}}" class="j-td-btn">
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
                                    <th>{{ ___('label.user') }}</th>
                                    <th>{{ ___('label.hub') }}</th>
                                    <th>{{ ___('label.coverage') }}</th>
                                    <th>{{ ___('label.pickup_slot') }}</th>
                                    <th>{{ ___('label.balance') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if( hasPermission('delivery_man_update') || hasPermission('delivery_man_delete') )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($deliveryMans as $key => $deliveryman)
                                <tr id="row_{{ $deliveryman->id }}">
                                    <td>{{++$key}}</td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ getImage($deliveryman->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="flex-grow-1 ml-2">
                                                <strong>{{$deliveryman->user->name}}</strong> <br>
                                                <span>{{$deliveryman->user->email}}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{@$deliveryman->user->hub->name}}</td>
                                    <td>{{@$deliveryman->coverage->name}}</td>
                                    <td>{{@$deliveryman->pickupSlot->title}}</td>

                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span>{{ ___('label.paid') }}:</span>
                                            <span class="whitespace-nowrap">{{ settings('currency') . " " . $deliveryman->paidCommission }}</span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <span>{{ ___('label.unpaid') }}:</span>
                                            <span class="whitespace-nowrap">{{ settings('currency') . " " . $deliveryman->unpaidCommission }}</span>
                                        </div>
                                    </td>

                                    <td> {!! $deliveryman->user->my_status !!} </td>

                                    @if( hasPermission('delivery_man_update') || hasPermission('delivery_man_delete') )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>

                                        <div class="dropdown-menu">
                                            @if( hasPermission('delivery_man_update') )
                                            <a href="{{route('deliveryman.edit',$deliveryman->id)}}" class="dropdown-item"> <i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }} </a>
                                            @endif

                                            @if(hasPermission('delivery_man_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/deliveryman/delete', {{$deliveryman->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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
                    </div>
                    <!-- pagination component -->
                    @if(count($deliveryMans))
                    <x-paginate-show :items="$deliveryMans" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
            <!-- end data table  -->
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection
@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
