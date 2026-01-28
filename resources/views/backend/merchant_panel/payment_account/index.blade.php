@extends('backend.partials.master')

@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.payment_account') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('merchant.payment_account') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">


        <div class="col-12">
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('merchant.payment_account') }} {{ ___('label.list') }}</h4>
                    @if(hasPermission('merchant_payment_account_create') )
                    <a href="{{ route('merchant.payment.account.create') }}" class="j-td-btn"> <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt=" "> <span>{{ ___('label.add') }} </span> </a>
                    @endif
                </div>

                <div class="card-body">
                    <table class="table  ">
                        <thead class="bg">
                            <tr>
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('merchant.method') }}</th>
                                <th>{{ ___('merchant.bank_info') }}</th>
                                <th>{{ ___('merchant.account') }}</th>
                                <th>{{ ___('label.status') }}</th>
                                @if(hasPermission('merchant_payment_account_update') || hasPermission('merchant_payment_account_delete') )
                                <th>{{ ___('label.actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($accounts as $key => $account)

                            <tr id="row_{{ $account->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ ___('merchant.'.$account->payment_method)}}</td>

                                <td>
                                    @if($account->payment_method == \App\Enums\Merchant_panel\PaymentMethod::bank)
                                    <span>Bank : {{$account->bank_name}}</span><br>
                                    <span>Branch : {{$account->branch_name}} </span><br>
                                    <span>Routing : {{$account->routing_no}} </span>
                                    @elseif($account->payment_method == \App\Enums\Merchant_panel\PaymentMethod::mfs)
                                    <span>MFS : {{$account->mfs}}</span>
                                    @endif
                                    @if ($account->payment_method != \App\Enums\Merchant_panel\PaymentMethod::cash)
                                    <br><span>Type : {{$account->account_type}}</span>
                                    @endif
                                </td>

                                <td>
                                    @if ($account->payment_method != \App\Enums\Merchant_panel\PaymentMethod::cash)
                                    <span>Name : {{$account->account_name}}</span><br>
                                    <span>Number : {{$account->account_no}} </span><br>
                                    <span>Mobile : {{$account->mobile_no}}</span>
                                    @endif
                                </td>

                                <td>{!! $account->my_status !!}</td>

                                @if( hasPermission('merchant_payment_account_update') || hasPermission('merchant_payment_account_delete') )
                                <td>
                                    <div class="d-flex" data-toggle="dropdown">
                                        <a class="p-2" href="javascript:void()">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                    </div>
                                    <div class="dropdown-menu">
                                        @if( hasPermission('merchant_payment_account_update') )
                                        <a href="{{route('merchant.payment.account.edit',$account->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                        @endif
                                        @if( hasPermission('merchant_payment_account_delete') )
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('merchant/payment/account/delete', {{$account->id}})"> <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }} </a>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>

                            @empty
                            <x-nodata-found :colspan="6" />
                            @endforelse
                        </tbody>
                    </table>
                    <!-- pagination component -->
                    @if(count($accounts))
                    <x-paginate-show :items="$accounts" />
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
