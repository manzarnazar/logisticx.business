@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel_list') }}
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

                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('common.list') }}</a></li>

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
                <div class="card-body">
                    <form action="{{ route('parcel.filter') }}" method="GET">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" id="date" name="parcel_date" placeholder="{{ ___('placeholder.enter_date_range')}}" class="form-control input-style-1 flatpickr-range" value="{{ old('parcel_date',request()->input('parcel_date')) }}">
                                @error('parcel_date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="parcel_merchant_id">{{ ___('parcel.merchant') }}</label>
                                <select id="parcel_merchant_id" name="parcel_merchant_id" class="form-control" data-url="{{ route('parcel.merchant.get') }}">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('merchant.merchant') }} </option>

                                    @if(request()->input('parcel_merchant_id'))
                                    @php
                                    $merchant = \App\Models\Backend\Merchant::find(request()->input('parcel_merchant_id'));
                                    @endphp
                                    <option value="{{ $merchant->id }}" selected> {{ $merchant->business_name }} </option>
                                    @endif

                                </select>
                                @error('parcel_merchant_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            @if (request()->is('parcels') || request()->is('admin/parcel/filter'))
                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="parcelStatus">{{ ___('parcel.status') }}</label>
                                <select id="parcelStatus" name="parcel_status" class="form-control">
                                    <option value="" selected> {{ ___('menus.select') }} {{ ___('label.status') }}</option>
                                    @foreach (config('site.status.parcel') as $key => $status)
                                    <option value="{{ $key }}" @selected(old('parcel_status', request()->input('parcel_status') ) == $key)> {{ ___('parcel.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('parcel_status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            @endif

                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="parcelDeliveryManID">{{ ___('parcel.deliveryman') }}</label>
                                <select id="parcelDeliveryManID" name="parcel_deliveryman_id" data-url="{{ route('parcel.deliveryman.search') }}" class="form-control input-style-1">
                                    <option value="">{{ ___('menus.select') }} {{ ___('parcel.delivery_man') }} </option>

                                    @if(request()->input('parcel_deliveryman_id'))
                                    @php
                                    $hero = \App\Models\Backend\DeliveryMan::with('user:id,name')->find(request()->input('parcel_deliveryman_id'));
                                    @endphp
                                    <option value="{{ $hero->id }}" selected> {{ $hero->user->name }} </option>
                                    @endif

                                </select>
                                @error('parcel_deliveryman_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcelPickupmanId">{{ ___('parcel.pickupman') }}</label>
                                <select id="parcelPickupmanId" name="parcel_pickupman_id" data-url="{{ route('parcel.deliveryman.search') }}" class="form-control input-style-1">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('parcel.pickup_man') }} </option>

                                    @if(request()->input('parcel_pickupman_id'))
                                    @php
                                    $hero = \App\Models\Backend\DeliveryMan::with('user:id,name')->find(request()->input('parcel_pickupman_id'));
                                    @endphp
                                    <option value="{{ $hero->id }}" selected> {{ $hero->user->name }} </option>
                                    @endif

                                </select>
                                @error('parcel_pickupman_id') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class=" label-style-1" for="invoice_id">{{ ___('parcel.invoice_id') }}</label>
                                <input id="invoice_id" type="text" name="invoice_id" placeholder="{{ ___('parcel.invoice_id') }}" autocomplete="off" class="form-control input-style-1" value="{{ old('invoice_id', request()->input('invoice_id') ) }}">
                                @error('parcel_customer_phone') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 j-create-btns">
                                <div class="drp-btns ">
                                    <button type="submit" class="j-td-btn"><i class="fa fa-filter"></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('parcel.index') }}" class="j-td-btn btn-red"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="card-header">
                    <h4 class="title-site">{{ ___('parcel.parcel_list') }}</h4>

                    <div class="card-table d-flex align-items-center">

                        <form class="j-search-form" action="{{ route('parcel.specific.search') }}" method="get">
                            @csrf
                            <input name="search" onkeyup="searchOnTable(this.value)" id="Psearch" class="j-form-control h-44px" type="text" placeholder="{{ ___('label.search') }}..." value="{{ request()->input('search') }}">
                            <button type="submit" class="j-form-btn"> <i class="icon-magnifier"> </i> </button>
                        </form>

                        @if (hasPermission('parcel_create'))

                        @if ( request()->input('parcel_status') == \App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN)
                        <a href="{{ route('parcel.parcel-bulkassign-print', ['parcels' => $parcelsPrint->pluck('id')->toArray(), 'delivery_man_id' => request()->input('parcel_deliveryman_id') ]) }}" class="j-td-btn" target="_blank" data-toggle="tooltip" data-placement="top" title="Print">{{ ___('parcel.print') }}</a>
                        @endif

                        <select class="form-control select2" id="selectAssignType">
                            <option></option>
                            <option value="assignpickupbulk">{{ ___('parcel.assign_pickup') }}</option>
                            <option value="transfer_to_hub_multiple_parcel">{{ ___('parcel.hub_transfer') }} </option>
                            <option value="received_by_hub_multiple_parcel">{{ ___('parcel.received_by_hub') }} </option>
                            <option value="delivery_man_assign_multiple_parcel"> {{ ___('parcel.delivery_man_assign') }}</option>
                            <option value="assign_return_merchant">{{ ___('parcel.assign_return_merchant') }} </option>
                        </select>

                        <a href="{{ route('parcel.importView') }}" class="j-td-btn" data-toggle="tooltip" data-placement="top" title="Parcel Import">
                            <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image">
                            <span>{{ ___('parcel.import_parcel') }} </span>
                        </a>

                        <a href="{{ route('parcel.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('parcel.add_parcel') }} </span> </a>

                        @endif

                    </div>

                </div>

                <div class="card-body mt-4">
                    <div class="table-responsive">
                        <table id="table" class="table   parcelTable">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('parcel.date') }}</th>
                                    <th>{{ ___('parcel.tracking_id') }}</th>
                                    <th>{{ ___('parcel.recipient_info') }}</th>
                                    <th>{{ ___('parcel.merchant') }}</th>
                                    <th>{{ ___('parcel.amount') }}</th>
                                    <th>{{ ___('parcel.status') }}</th>
                                    <th>{{ ___('label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($parcels as $key => $parcel)
                                <tr id="row_{{ $parcel->id }}">

                                    <td> {{ ++$key }}</td>
                                    <td> {{ dateTimeFormat($parcel->created_at) }}</td>
                                    <td><a href="{{ route('parcel.details', $parcel->id) }}"> {{ $parcel->tracking_id }} </a></td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $parcel->customer_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-phone.png" alt="no image">
                                                <span>{{ $parcel->customer_phone }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span> {{ $parcel->customer_address }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="parcel-list">
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-user.png" alt="no image">
                                                <span>{{ $parcel->merchant->business_name }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-phone.png" alt="no image">
                                                <span>{{ $parcel->merchant->user->mobile }}</span>
                                            </li>
                                            <li>
                                                <img src="{{ asset('backend') }}/icons/icon/parcel-location.png" alt="no image">
                                                <span>{{ $parcel->merchant->address }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td>
                                        <ul class="parcel-total">
                                            <li class="d-flex justify-content-between gap-2">
                                                <span> {{ ___('label.cod') }}: </span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->cash_collection }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ___('label.charge') }}:</span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->total_charge }}</span>
                                            </li>
                                            <li class="d-flex justify-content-between">
                                                <span>{{ ___('label.payable') }}:</span>
                                                <span class="whitespace-nowrap">{{ settings('currency') . " " . $parcel->parcelTransaction->current_payable }}</span>
                                            </li>
                                        </ul>
                                    </td>

                                    <td title="{{ ___('parcel.updated_on') }}: {{ dateTimeFormat($parcel->updated_at) }}"> {!! $parcel->parcel_status !!} </td>

                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend be-addon">
                                                <div class="d-flex" data-toggle="dropdown">
                                                    <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                                </div>
                                                <div class="dropdown-menu">

                                                    @if (hasPermission('parcel_status_update') )
                                                    {!! parcelStatus($parcel) !!}
                                                    @endif

                                                    <a href="{{ route('parcel.details', $parcel->id) }}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{ ___('label.view') }}</a>
                                                    <a href="{{ route('parcel.clone', $parcel->id) }}" class="dropdown-item"><i class="fa fa-clone" aria-hidden="true"></i> {{ ___('label.clone') }}</a>
                                                    <a href="{{ route('parcel.print', $parcel->id) }}" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i> {{ ___('label.print') }}</a>
                                                    <a href="{{ route('parcel.print-label', $parcel->id) }}" target="_blank" class="dropdown-item"><i class="fa fa-print" aria-hidden="true"></i> {{ ___('label.print_label') }}</a>


                                                    @if (hasPermission('parcel_update') && $parcel->status == \App\Enums\ParcelStatus::PENDING)
                                                    <a href="{{ route('parcel.edit', $parcel->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                                    @endif

                                                    @if (hasPermission('parcel_delete') && $parcel->status == \App\Enums\ParcelStatus::PENDING)
                                                    <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('parcel/delete', {{ $parcel->id }})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
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

                        @include('backend.parcel.pickup_assign_modal')
                        @include('backend.parcel.pickup_re_schedule')
                        @include('backend.parcel.received_by_pickup')
                        @include('backend.parcel.transfer_to_hub')
                        @include('backend.parcel.received_by_hub')
                        @include('backend.parcel.delivery_man_assign')
                        @include('backend.parcel.delivery_reschedule')
                        @include('backend.parcel.partial_delivered_modal')
                        @include('backend.parcel.delivered_modal')
                        @include('backend.parcel.received_warehouse')
                        @include('backend.parcel.return_to_qourier')
                        @include('backend.parcel.return_assign_to_merchant')
                        @include('backend.parcel.re_schedule_return_assign_to_merchant')
                        @include('backend.parcel.return_received_by_merchant')

                        {{-- bulk models  --}}
                        @include('backend.parcel.assign_pickup_bulk')
                        @include('backend.parcel.transfer_to_hub_multiple_parcel')
                        @include('backend.parcel.received_by_hub_multiple_parcel')
                        @include('backend.parcel.delivery_man_assign_multiple_parcel')
                        @include('backend.parcel.assign_return_to_merchant_bulk')

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

<!-- end wrapper  -->
@endsection()

<!-- js  -->
@push('scripts')


<script type="text/javascript">
    var merchantUrl = "{{ route('parcel.merchant.get') }}";
    var merchantID = "{{ request()->input('parcel_merchant_id') }}";
    var deliveryManID = "{{ request()->input('parcel_deliveryman_id') }}";
    var pickupManID = "{{ request()->input('parcel_pickupman_id') }}";
    var dateParcel = "{{ request()->input('parcel_date') }}";

    $(document).ready(function() {
        $('#selectAssignType').select2({
            placeholder: "{{ ___('label.select_bulk_type') }}"
        });
    });

</script>

<script src="{{ asset('backend/js/onscan.min.js') }}"></script>
<script src="{{ asset('backend/js/custom/parcel/custom.js') }}"></script>
<script src="{{ asset('backend/js/custom/parcel/filter.js') }}"></script>

@include('backend.partials.delete-ajax')

@endpush
