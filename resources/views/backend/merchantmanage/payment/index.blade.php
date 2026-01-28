@extends('backend.partials.master')
@section('title')
{{ ___('merchant.merchant') }} {{ ___('merchant.payment') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.index') }}" class="breadcrumb-link">{{ ___('merchant.merchant') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('merchant.manage.payment.index') }}" class="breadcrumb-link">{{ ___('merchant.payment') }}</a></li>
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
                    <div class="card-body">
                        <form action="{{route('merchantmanage.payment.filter')}}" method="GET">
                            @csrf

                            <div class="form-row">
                                <div class="form-group col-12 col-sm-6 col-md-3">
                                    <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                    <input type="date" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ old('date',$request->date) }}" placeholder="{{___('placeholder.enter_date_range')}}">
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-3">
                                    <label class="label-style-1" for="merchant">{{ ___('merchant.merchant') }}</label>
                                    <input id="mercant_url" data-url="{{ route('merchant-manage.merchant-search') }}" type="hidden" />
                                    <select id="merchant" name="merchant_id" class="form-control input-style-1 select2" data-url="{{ route('merchant-manage.merchant.account') }}">
                                        <option value=""> {{ ___('menus.select') }} {{ ___('merchant.merchant') }}</option>
                                        @if ($request->merchant_id)
                                        <option value="{{ $merchant->id }}" selected> {{$merchant->business_name}} </option>
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                    <label class="label-style-1" for="merchant_account">{{ ___('merchant.merchant_account') }}</label>
                                    <select id="merchant_account" name="merchant_account" class="form-control input-style-1 select2">
                                        <option value=""> {{ ___('menus.select') }} {{ ___('merchant.merchant_account') }}</option>
                                        @if(isset($merchantaccounts))
                                        @foreach ($merchantaccounts as $maccounts)
                                        @if($maccounts->payment_method == 'bank')
                                        <option value='{{ $maccounts->id }}' @if($maccounts->id == $request->merchant_account) selected @endif> {{ $maccounts->holder_name  }} | {{ $maccounts->bank_name }} | {{ $maccounts->account_no }} | {{ $maccounts->branch_name}}</option>
                                        @elseif($maccounts->payment_method == 'mobile')
                                        <option value='{{ $maccounts->id }}' @if($maccounts->id == $request->merchant_account) selected @endif>{{ $maccounts->mobile_company }} | {{ $maccounts->mobile_no }} | {{ $maccounts->account_type }}</option>
                                        @elseif($maccounts->payment_method == 'cash')
                                        <option value='{{ $maccounts->id }}' @if($maccounts->id == $request->merchant_account) selected @endif> Cash </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                    <label class="label-style-1" for="hub_id">{{ ___('label.from_account') }}</label>
                                    <select id="hub_id" name="from_account" class="form-control input-style-1 select2">
                                        <option value=""> {{ ___('menus.select') }} {{ ___('label.from_account') }}</option>
                                        @foreach ($accounts as $account)
                                        @if ($account->gateway == 1)
                                        <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif>{{ $account->user->name }} | {{ ___('merchant.cash') }} : {{ $account->balance }} </option>
                                        @elseif($account->gateway == 3 || $account->gateway == 4 || $account->gateway == 5)
                                        <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif>{{$account->account_holder_name}} |No : {{ $account->mobile }}| @if($account->account_type == 1) {{ ___('merchant.merchant') }} @else {{ ___('placeholder.persional') }} @endif | {{ ___('merchant.current_balance') }}: {{ $account->balance }} </option>
                                        @else
                                        <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif>{{$account->account_holder_name}} | A.No : {{ $account->account_no }} | {{ ___('merchant.current_balance') }}: {{ $account->balance }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="j-create-btns">
                                <div class="drp-btns">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('merchant.manage.payment.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="j-parcel-main j-parcel-res">
                <div class="card">

                    <div class="card-header mb-3">
                        <h4 class="title-site">{{ ___('merchant.merchant_payment_manage') }}</h4>
                        @if(hasPermission('payment_create') == true )
                        <a href="{{route('merchant-manage.payment.create')}}" class="j-td-btn">
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
                                        <th>{{ ___('merchant.merchant_details') }}</th>
                                        <th>{{ ___('account.to_account') }}</th>
                                        <th>{{ ___('account.from_account') }}</th>
                                        <th>{{ ___('label.amount') }}</th>
                                        <th>{{ ___('label.status') }}</th>
                                        @if( hasPermission('payment_reject') || hasPermission('payment_process') || hasPermission('payment_update') || hasPermission('payment_delete') )
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
                                            <div class="d-flex">
                                                <div class="mr-2">
                                                    <img src="{{ getImage(@$payment->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded" width="40" height="40">
                                                </div>
                                                <div>
                                                    {{-- <span  class="d-block">Name : <strong>{{$payment->merchant->user->name}}</strong></span> --}}
                                                    <span class="d-block">Business : {{ $payment->merchant->business_name }} </span>
                                                    <span class="d-block">Email : {{$payment->merchant->user->email}}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            @if ( $payment->merchantAccount->payment_method == config('merchantpayment.payment_method.bank') )
                                            <span>Bank : {{ $payment->merchantAccount->bank_name }} </span><br>
                                            <span>Name : {{ $payment->merchantAccount->account_name }} </span><br>
                                            <span>Noumber : {{ $payment->merchantAccount->account_no }} </span><br>
                                            {{-- <span>Branch : {{ $payment->merchantAccount->branch_name }} </span><br> --}}
                                            {{-- <span>Routing : {{ $payment->merchantAccount->routing_no }} </span> --}}

                                            @elseif ( $payment->merchantAccount->payment_method == config('merchantpayment.payment_method.mfs') )
                                            <span>MFS : {{ $payment->merchantAccount->mfs }} </span><br>
                                            <span>Mobile : {{ $payment->merchantAccount->mobile_no }} </span><br>
                                            <span>Type : {{ $payment->merchantAccount->account_type }} </span>

                                            @elseif ( $payment->merchantAccount->payment_method == config('merchantpayment.payment_method.cash'))
                                            <span> Cash </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if(@$payment->frompayment->account_holder_name) <div>{{ 'Name: ' . @$payment->frompayment->account_holder_name }}</div> @endif
                                            @if(@$payment->frompayment->account_no) <div>{{ 'Number: ' . @$payment->frompayment->account_no }}</div> @endif
                                            @if(@$payment->frompayment->branch_name) <div>{{ 'Branch: ' . @$payment->frompayment->branch_name }}</div> @endif
                                            @if(@$payment->frompayment->mobile) <div>{{ 'Mobile: ' . @$payment->frompayment->mobile }}</div> @endif
                                        </td>

                                        <td>
                                            <span>{{ ___('merchant.amount') }} : {{@settings('currency')}}{{$payment->amount}}</span><br>
                                            <span>{{ ___('merchant.transaction_id') }} : {{$payment->transaction_id}}</span>
                                            @if($payment->referencefile !==null) <br>
                                            <span>{{ ___('merchant.reference') }}: </span>
                                            <a href=" {{ asset($payment->referencefile->original) }}" download="reference">Download</a>
                                            @endif
                                        </td>

                                        <td> {!! @$payment->myStatus !!} </td>

                                        <td>

                                            <div class="d-flex" data-toggle="dropdown">
                                                <a class="p-2" href="javascript:void()"> <i class="fa fa-ellipsis-v"></i> </a>
                                            </div>

                                            <div class="dropdown-menu">

                                                <a href="{{ route('merchantManage.payment.view', $payment->id) }}" class="dropdown-item"><i class="fa fa-eye"></i> {{ ___('label.view') }}</a>

                                                @if ( $payment->status == \App\Enums\ApprovalStatus::PROCESSED)
                                                <a onclick="pleaseConfirm(event)" href="{{route('merchantmanage.payment.cancel-process',$payment->id)}}" class="dropdown-item"><i class="fa fa-check"></i> {{ ___('label.cancel_process') }}</a>
                                                @endif

                                                @if ( $payment->status == \App\Enums\ApprovalStatus::REJECT)
                                                <a onclick="pleaseConfirm(event)" href="{{route('merchantmanage.payment.cancel-reject',$payment->id)}}" class="dropdown-item"><i class="fa fa-ban"></i> {{ ___('label.cancel_reject') }}</a>
                                                @endif


                                                @if ( $payment->status == \App\Enums\ApprovalStatus::PENDING)

                                                @if( hasPermission('payment_reject') )
                                                <a onclick="pleaseConfirm(event)" href="{{route('merchantmanage.payment.reject',$payment->id)}}" class="dropdown-item"><i class="fa fa-ban"></i> {{ ___('label.reject') }}</a>
                                                @endif

                                                @if( hasPermission('payment_process') )
                                                <a href="{{route('merchantmanage.payment.process',$payment->id)}}" class="dropdown-item"><i class="fa fa-check"></i> {{ ___('label.process') }}</a>
                                                @endif

                                                @if( hasPermission('payment_update') )
                                                <a href="{{route('merchatmanage.payment.edit',$payment->id)}}" class="dropdown-item"><i class="fa fa-edit"></i> {{ ___('label.edit') }}</a>
                                                @endif

                                                @if( hasPermission('payment_delete') )
                                                <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/payment/delete', {{$payment->id}})"> <i class="fa fa-trash"></i> {{ ___('label.delete') }} </a>
                                                @endif

                                                @endif

                                            </div>
                                        </td>
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
</div>
<!-- end wrapper  -->
@endsection()


@push('scripts')

<script src="{{ asset('backend/js/custom/merchant/payment_curd.js') }}"></script>

@include('backend.partials.delete-ajax')

@endpush
