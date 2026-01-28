@extends('backend.partials.master')
@section('title')
{{ ___('hub.title') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('label.title') }}</a></li>
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
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('hub.title') }} {{ ___('hub.payment')}} {{ ___('label.list')}}</h4>
                    @if(hasPermission('hub_payment_create'))
                    <a href="{{route('hub.hub-payment.create')}}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.hub') }}</th>
                                    <th>{{ ___('account.to_account') }}</th>
                                    <th>{{ ___('account.from_account') }}</th>
                                    <th>{{ ___('hub.amount') }}</th>
                                    <th>{{ ___('hub.description') }}</th>
                                    <th>{{ ___('label.status') }}</th>

                                    @if( hasPermission('hub_payment_reject') || hasPermission('hub_payment_process') || hasPermission('hub_payment_update') || hasPermission('hub_payment_delete') )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($payments as $key => $payment)
                                <tr id="row_{{ $payment->id }}">
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $payment->hub->name }}</td>

                                    <td>
                                        @if(@$payment->hubAccount->account_holder_name) <div>{{ 'Name: ' . @$payment->hubAccount->account_holder_name }}</div> @endif
                                        @if(@$payment->hubAccount->account_no) <div>{{ 'Number: ' . @$payment->hubAccount->account_no }}</div> @endif
                                        @if(@$payment->hubAccount->branch_name) <div>{{ 'Branch: ' . @$payment->hubAccount->branch_name }}</div> @endif
                                        @if(@$payment->hubAccount->mobile) <div>{{ 'Mobile: ' . @$payment->hubAccount->mobile }}</div> @endif
                                    </td>

                                    <td>
                                        @if(@$payment->fromAccount->account_holder_name) <div>{{ 'Name: ' . @$payment->fromAccount->account_holder_name }}</div> @endif
                                        @if(@$payment->fromAccount->account_no) <div>{{ 'Number: ' . @$payment->fromAccount->account_no }}</div> @endif
                                        @if(@$payment->fromAccount->branch_name) <div>{{ 'Branch: ' . @$payment->fromAccount->branch_name }}</div> @endif
                                        @if(@$payment->fromAccount->mobile) <div>{{ 'Mobile: ' . @$payment->fromAccount->mobile }}</div> @endif
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

                                    <td> {!! @$payment->myStatus !!} </td>


                                    @if( hasPermission('hub_payment_reject') || hasPermission('hub_payment_process') || hasPermission('hub_payment_update') || hasPermission('hub_payment_delete') )
                                    <td>

                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>

                                        <div class="dropdown-menu">

                                            @if ( $payment->status == \App\Enums\ApprovalStatus::PROCESSED)
                                            <a onclick="pleaseConfirm(event)" href="{{route('hub-payment.cancel-process',$payment->id)}}" class="dropdown-item" data-question="{{ ___('hub.cancel_process_question') }}"><i class="fa fa-check"></i> {{ ___('label.cancel_process') }}</a>
                                            @endif

                                            @if ( $payment->status == \App\Enums\ApprovalStatus::REJECT)
                                            <a onclick="pleaseConfirm(event)" href="{{route('hub-payment.cancel-reject',$payment->id)}}" class="dropdown-item" data-question="{{ ___('hub.cancel_reject_question') }}"><i class="fa fa-ban"></i> {{ ___('label.cancel_reject') }}</a>
                                            @endif

                                            @if ( $payment->status == \App\Enums\ApprovalStatus::PENDING)

                                            @if( hasPermission('hub_payment_reject') )
                                            <a onclick="pleaseConfirm(event)" href="{{route('hub-payment.reject',$payment->id)}}" class="dropdown-item" data-question="{{ ___('hub.payment_reject_question') }}"><i class="fa fa-ban"></i> {{ ___('label.reject') }}</a>
                                            @endif

                                            @if( hasPermission('hub_payment_process') )
                                            <a href="{{route('hub-payment.process',$payment->id)}}" class="dropdown-item"><i class="fa fa-check"></i> {{ ___('label.process') }}</a>
                                            @endif

                                            @if( hasPermission('hub_payment_update') )
                                            <a href="{{route('hub.hub-payment.edit',$payment->id)}}" class="dropdown-item"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                            @endif

                                            @if( hasPermission('payment_delete') )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('hub/payment/request/delete', {{$payment->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif

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
                    @if(count($payments))
                    <x-paginate-show :items="$payments" />
                    @endif

                    <!-- pagination component -->
                </div>
            </div>
        </div>
    </div>
    <!-- end data table  -->
</div>

<!-- end wrapper  -->
@endsection



@push('scripts')

@include('backend.partials.delete-ajax')

<script src="{{ asset('backend/js/custom/hub/payment.js') }}"></script>

@endpush
