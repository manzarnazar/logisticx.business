@extends('backend.partials.master')
@section('title')
{{ ___('charges.charge_list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('charge.index') }}" class="breadcrumb-link">{{ ___('charges.charges') }}</a></li>
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
                    <h4 class="title-site">{{ ___('charges.charge_list') }}</h4>
                    @if (hasPermission('charges_create'))
                    <a href="{{ route('charges.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('charges.product') }}</th>
                                    <th>{{ ___('charges.service') }}</th>
                                    <th>{{ ___('charges.area') }}</th>
                                    <th>{{ ___('charges.time') }}</th>
                                    <th>{{ ___('charges.delivery_charge') }}</th>
                                    <th>{{ ___('charges.hero_commission') }}</th>
                                    <th>{{ ___('charges.return') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if (hasPermission('charges_update') || hasPermission('charges_delete'))
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($charges as $key => $charge)
                                <tr id="row_{{ $charge->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $charge->productCategory->name }}</td>
                                    <td>{{ $charge->serviceType->name }}</td>
                                    <td>{{ ___('charges.' . $charge->area) }}</td>
                                    <td>{{ $charge->delivery_time . " " . ___('charges.hour')}} </td>

                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span> {{ ___('label.regular') }} : </span>
                                            <span class="whitespace-nowrap"> {{ @settings('currency') . " " . $charge->charge }} </span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <span> {{ ___('label.additional') }} : </span>
                                            <span class="whitespace-nowrap"> {{ @settings('currency') . " " . $charge->additional_charge }} </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-between">
                                            <span> {{ ___('label.regular') }} : </span>
                                            <span class="whitespace-nowrap"> {{ @settings('currency') . " " . $charge->delivery_commission }} </span>
                                        </div>

                                        <div class="d-flex justify-content-between">
                                            <span> {{ ___('label.additional') }} : </span>
                                            <span class="whitespace-nowrap"> {{ @settings('currency') . " " . $charge->additional_delivery_commission }} </span>
                                        </div>
                                    </td>

                                    <td>{{ $charge->return_charge }} %</td>
                                    <td>{!! $charge->my_status !!}</td>

                                    @if (hasPermission('charges_update') || hasPermission('charges_delete'))
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if (hasPermission('charges_update'))
                                            <a href="{{ route('charges.edit', $charge->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if (hasPermission('charges_delete'))
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/charges/charge/delete', {{ $charge->id }})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="10" />
                                @endforelse
                            </tbody>
                            <!-- end data table  -->
                        </table>
                    </div>
                    <!-- pagination component -->
                    @if (count($charges))
                    <x-paginate-show :items="$charges" />
                    @endif
                    <!-- end pagination component -->
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
