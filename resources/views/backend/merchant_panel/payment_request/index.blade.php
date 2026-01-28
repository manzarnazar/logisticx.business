@extends('backend.partials.master')
@section('title')
{{ ___('label.payments') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.payment-request.index') }}" class="breadcrumb-link">{{ ___('label.payment') }}</a></li>
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
                    <h4 class="title-site"> {{ ___('label.payments') }}</h4>
                    <a href="{{route('merchant-panel.payment-request.create')}}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span> </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('account.account_details') }}</th>
                                    <th>{{ ___('merchant.description') }}</th>
                                    <th>{{ ___('merchant.amount') }}</th>
                                    <th>{{ ___('account.request_date') }}</th>
                                    <th>{{ ___('label.status') }}</th>
                                    <th>{{ ___('label.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $key => $payment)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>
                                        @if ($payment->merchantAccount->payment_method == config('merchantpayment.payment_method.bank'))
                                        <span>Bank : {{ $payment->merchantAccount->bank_name }} </span><br>
                                        <span>Name : {{ $payment->merchantAccount->account_name }} </span><br>
                                        <span>Noumber : {{ $payment->merchantAccount->account_no }} </span><br>
                                        {{-- <span>Branch : {{ $payment->merchantAccount->branch_name }} </span><br> --}}
                                        {{-- <span>Routing : {{ $payment->merchantAccount->routing_no }} </span> --}}

                                        @elseif ($payment->merchantAccount->payment_method == config('merchantpayment.payment_method.mfs'))
                                        <span>MFS : {{ $payment->merchantAccount->mfs }} </span><br>
                                        <span>Mobile : {{ $payment->merchantAccount->mobile_no }} </span><br>
                                        <span>Type : {{ $payment->merchantAccount->account_type }} </span>

                                        @elseif ($payment->merchantAccount->payment_method == config('merchantpayment.payment_method.cash'))
                                        <span> Cash </span>
                                        @endif

                                        @if($payment->transaction_id) <div> {{ ___('merchant.transaction_id') }} : {{$payment->transaction_id}} </div> @endif

                                        @if($payment->referencefile !==null)
                                        <div> <a href=" {{ asset($payment->referencefile->original) }}" download="reference">Download {{ ___('label.download_receipt') }}</a> </div>
                                        @endif

                                    </td>

                                    <td>{{$payment->description}} </td>
                                    <td>{{settings('currency')}}{{$payment->amount}}</td>
                                    <td>{{ date('d M Y H:i:s a',strtotime($payment->created_at)) }} </td>
                                    <td>
                                        @if($payment->status == \App\Enums\ApprovalStatus::REJECT)
                                        <span class="bullet-badge bullet-badge-danger">{{___('label.reject') }}</span>
                                        @elseif($payment->status == \App\Enums\ApprovalStatus::PENDING)
                                        <span class="bullet-badge bullet-badge-warning">{{___('label.pending') }}</span>
                                        @elseif($payment->status == \App\Enums\ApprovalStatus::PROCESSED)
                                        <span class="bullet-badge bullet-badge-success">{{___('label.processed') }}</span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        @if($payment->status == \App\Enums\ApprovalStatus::REJECT)
                                        <span class="bullet-badge bullet-badge-danger">{{trans('approvalstatus.'.\App\Enums\ApprovalStatus::REJECT) }}</span>
                                        @elseif($payment->status == \App\Enums\ApprovalStatus::PENDING)
                                        <span class="bullet-badge bullet-badge-warning">{{trans('approvalstatus.'.\App\Enums\ApprovalStatus::PENDING) }}</span>
                                        @elseif($payment->status == \App\Enums\ApprovalStatus::PROCESSED)
                                        <span class="bullet-badge bullet-badge-success">{{trans('approvalstatus.'.\App\Enums\ApprovalStatus::PROCESSED) }}</span>
                                        @endif
                                    </td> --}}

                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                        </div>

                                        <div class="dropdown-menu">

                                            <a href="{{ route('merchantManage.payment.view', $payment->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> {{ ___('label.view') }}</a>

                                            @if($payment->created_by == \App\Enums\UserType::MERCHANT && $payment->status == \App\Enums\ApprovalStatus::PENDING)
                                            <a href="{{ route('merchant-panel.payment-request.edit',$payment->id) }}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('merchant/payment-request/delete', {{$payment->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                            @endif

                                        </div>
                                    </td>

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
@endsection()

@push('scripts')

@include('backend.partials.delete-ajax')

@endpush
