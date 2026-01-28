@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- page header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>

                            @if(@$slugText != null)
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ $slugText }}</a></li>
                            @endif

                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>


                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end page header -->
    <div class="row">
        <!-- data table  -->
        <div class="col-12">
            <div class="card">

                <div class="card-header">
                    <h4 class="title-site"> {{ @$slugText }} {{ ___('parcel.parcel_list') }}</h4>
                </div>

                <div class="card-body mt-3">
                    <div class="table-responsive">
                        <table id="table" class="table   parcelTable">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('parcel.recipient_info') }}</th>
                                    <th>{{ ___('parcel.merchant') }}</th>
                                    <th>{{ ___('parcel.cod') }}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parcels as $key => $parcel)
                                <tr id="row_{{ $parcel->id }}">

                                    <td> {{ ++$key }}</td>
                                    <td> {{ dateTimeFormat($parcel->created_at) }}</td>
                                    <td>
                                        @if (hasPermission('parcel_details_read'))
                                        <a href="{{ route('parcel.details', $parcel->id) }}"> {{ $parcel->tracking_id }} </a>
                                        @else
                                        {{ $parcel->tracking_id }}
                                        @endif
                                    </td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-user.png') }}" alt="no image">
                                                <span>{{ $parcel->customer_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-phone.png') }}" alt="no image">
                                                <span>{{ $parcel->customer_phone }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-location.png') }}" alt="no image">
                                                <span> {{ $parcel->customer_address }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-user.png') }}" alt="no image">
                                                <span>{{ $parcel->merchant->business_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-phone.png') }}" alt="no image">
                                                <span>{{ $parcel->merchant->user->mobile }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend/icons/icon/parcel-location.png') }}" alt="no image">
                                                <span>{{ $parcel->merchant->address }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td> {{ settings('currency')  . ' ' .$parcel->parcelTransaction->cash_collection }} </td>

                                    <td title="{{ ___('parcel.updated_on') }}: {{ dateTimeFormat($parcel->updated_at) }}"> {!! $parcel->parcel_status !!} </td>

                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend be-addon">
                                                <div class="d-flex" data-toggle="dropdown">
                                                    <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                                </div>
                                                <div class="dropdown-menu">

                                                    @if ($parcel->status == \App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN || $parcel->status == \App\Enums\ParcelStatus::DELIVERY_RE_SCHEDULE)

                                                    <a class="dropdown-item" onclick="setParcelId({{ $parcel->id }}, '#deliveredModal form #parcel_id')" data-toggle="modal" data-target="#deliveredModal" href="#"> <i class="fa fa-share"></i> {{ ___('parcel.delivered') }}</a>

                                                    <a class="dropdown-item" onclick="setParcelId({{ $parcel->id }}, '#partialDeliveredModal form #parcel_id')" data-toggle="modal" data-target="#partialDeliveredModal" href="#"> <i class="fa fa-share"></i> {{ ___('parcel.partial_delivered') }}</a>
                                                    @endif

                                                    @if ($parcel->status == \App\Enums\ParcelStatus::DELIVERED)
                                                    <a class="dropdown-item" data-question="{{ ___('parcel.cancel_delivered_question') }}" href="{{ route("parcel.delivered-cancel", $parcel->id) }}" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> {{___('parcel.delivered_cancel') }}</a>
                                                    @endif

                                                    @if ($parcel->status == \App\Enums\ParcelStatus::PARTIAL_DELIVERED)
                                                    <a class="dropdown-item" data-question="{{ ___('parcel.cancel_partial_delivered_question') }}" href="{{ route("parcel.partial-delivered-cancel", $parcel->id) }}" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> {{ ___('parcel.partial_delivered_cancel' ) }}</a>
                                                    @endif


                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="9" />
                                @endforelse
                            </tbody>
                        </table>

                        @include('backend.deliveryman_panel.parcel.modals.delivered_modal')
                        @include('backend.deliveryman_panel.parcel.modals.partial_delivered_modal')


                    </div>
                    <!-- pagination component -->
                    @if (count($parcels))
                    <x-paginate-show :items="$parcels" />
                    @endif
                    <!-- pagination component -->
                </div>
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
<script src="{{ asset('backend/js/custom/parcel/hero_parcel_task.js') }}"></script>
@endpush
