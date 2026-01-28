@extends('backend.partials.master')
@section('title')
{{ ___('account.hub_payment_request') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('hub-panel.payment-request.index') }}" class="breadcrumb-link">{{ ___('account.hub_payment_request') }}</a></li>
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
                    <h4 class="title-site">{{ ___('account.hub_payment_request') }}</h4>
                    @if(hasPermission('hub_payment_request_create') )
                    <a href="{{route('hub-panel.payment-request.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif
                </div>



                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('hub.account') }}</th>
                                    <th>{{ ___('hub.amount') }}</th>
                                    <th>{{ ___('hub.description') }}</th>
                                    <th>{{ ___('account.request_date') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    @if( hasPermission('hub_payment_request_update') == true || hasPermission('hub_payment_request_delete') == true )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($payments as $payment)
                                <tr id="row_{{ $payment->id }}">
                                    <td>{{$i++}}</td>

                                    <td>
                                        @if(@$payment->hubAccount->account_holder_name) <div>{{ 'Name: ' . @$payment->hubAccount->account_holder_name }}</div> @endif
                                        @if(@$payment->hubAccount->account_no) <div>{{ 'Number: ' . @$payment->hubAccount->account_no }}</div> @endif
                                        @if(@$payment->hubAccount->branch_name) <div>{{ 'Branch: ' . @$payment->hubAccount->branch_name }}</div> @endif
                                        @if(@$payment->hubAccount->mobile) <div>{{ 'Mobile: ' . @$payment->hubAccount->mobile }}</div> @endif
                                    </td>


                                    <td> {{@settings('currency')}}{{$payment->amount}} </td>

                                    <td>
                                        {{\Str::limit($payment->description,100,' ...')}}

                                        @if($payment->transaction_id )
                                        <div class="pt-2"> <span>{{ ___('account.transaction_id') }} : {{$payment->transaction_id}}</span></div>
                                        @endif
                                        @if($payment->referencefile )
                                        <div class="pt-2"> <span>{{ ___('account.reference') }}: </span> <a href=" {{ asset($payment->referencefile->original) }}" download="reference">Download</a></div>
                                        @endif

                                    </td>

                                    <td> {{ dateTimeFormat($payment->created_at) }} </td>

                                    <td> {!! @$payment->myStatus !!} </td>


                                    @if( hasPermission('hub_payment_request_update') || hasPermission('hub_payment_request_delete') )
                                    <td>
                                        @if($payment->status == \App\Enums\ApprovalStatus::PENDING)
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>
                                        <div class="dropdown-menu">

                                            @if(hasPermission('hub_payment_request_update') )
                                            <a href="{{route('hub-panel.payment-request.edit',$payment->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if( hasPermission('hub_payment_request_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('hub-panel/payment-request/delete', {{$payment->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif
                                        </div>
                                        @else
                                        ...
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                        <!-- pagination component -->
                        @if(count($payments))
                        <x-paginate-show :items="$payments" />
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
