@extends('backend.partials.master')
@section('title')
{{ ___('payment.title') }} {{ ___('label.view') }}
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
                            <li class="breadcrumb-item"><a href="{{route('income.index')}}" class="breadcrumb-link">{{ ___('label.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.details')}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex">
                            <div class="mr-1">
                                <img class="d-block" src="{{ favicon(@settings('favicon') ) }}" alt="">
                            </div>
                            <h4> {{ @settings('name') }} </h4>
                        </div>
                        <div>
                            <a href="{{route('support.add')}}" class="btn btn-outline-secondary"> {{ ___('label.open_ticket') }} </a>

                            @if(auth()->user()->user_type != \App\Enums\UserType::MERCHANT && $payment->status == \App\Enums\ApprovalStatus::PENDING)
                            <a href="{{route('merchatmanage.payment.edit',@$payment->id) }}" class="btn btn-outline-primary"> <i class="fas fa-edit"></i> {{ ___('label.edit') }}</a>
                            @endif

                            @if(auth()->user()->user_type == \App\Enums\UserType::MERCHANT && $payment->status == \App\Enums\ApprovalStatus::PENDING)
                            <a href="{{route('merchant-panel.payment-request.edit',@$payment->id) }}" class="btn btn-outline-primary"> <i class="fas fa-edit"></i> {{ ___('label.edit') }}</a>
                            @endif

                        </div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap mb-3 gap-3">
                        <div class="table-responsive w-auto">
                            <table class="table mb-1">
                                <tbody>

                                    <tr>
                                        <td> <b>{{ ___('label.merchant')}}</b>: </td>
                                        <td> {{ @$payment->merchant->business_name }}</td>
                                    </tr>

                                    <tr>
                                        <td> <b>{{ ___('label.address')}}</b>: </td>
                                        <td>{{ @$payment->merchant->address }}</td>
                                    </tr>

                                    <tr>
                                        <td> <b>{{ ___('label.mobile_number')}}</b>: </td>
                                        <td> {{ @$payment->merchant->user->mobile }}</td>
                                    </tr>

                                    @if($payment->merchantAccount->payment_method==config('merchantpayment.payment_method.cash'))
                                    <tr>
                                        <td> <b>{{ ___('label.payment_method')}}</b>: </td>
                                        <td> Cash </td>
                                    </tr>
                                    @endif


                                    @if($payment->merchantAccount->bank )
                                    <tr>
                                        <td> <b>{{ ___('label.bank')}}</b>: </td>
                                        <td> {{ @$payment->merchantAccount->bank->bank_name }}</td>
                                    </tr>
                                    @endif

                                    @if($payment->merchantAccount->account_name )
                                    <tr>
                                        <td> <b>{{ ___('label.account_name')}}</b>: </td>
                                        <td> {{ @$payment->merchantAccount->account_name }}</td>
                                    </tr>
                                    @endif

                                    @if($payment->merchantAccount->account_no )
                                    <tr>
                                        <td> <b>{{ ___('label.account_number')}}</b>: </td>
                                        <td> {{ @$payment->merchantAccount->account_no }}</td>
                                    </tr>
                                    @endif

                                    @if( @$payment->merchantAccount->mfs)
                                    <tr>
                                        <td> <b>{{ ___('merchant.mfs')}}</b>: </td>
                                        <td> {{ @$payment->merchantAccount->mfs }}</td>
                                    </tr>
                                    @endif



                                </tbody>
                            </table>

                        </div>

                        <div class="table-responsive w-auto">
                            <table class="table table-sm table-bordered border-primary">
                                <tbody>

                                    @if(@$payment->frompayment->account_holder_name)
                                    <tr>
                                        <td><b>{{ ___('label.account_name') }}</b></td>
                                        <td>{{ @$payment->frompayment->account_holder_name }} </td>
                                    </tr>
                                    @endif

                                    @if(@$payment->frompayment->account_no)
                                    <tr>
                                        <td><b>{{ ___('label.account_number') }}</b></td>
                                        <td>{{ @$payment->frompayment->account_no }} </td>
                                    </tr>
                                    @endif

                                    @if(@$payment->frompayment->branch_name)
                                    <tr>
                                        <td><b>{{ ___('Branch') }}</b></td>
                                        <td>{{ @$payment->frompayment->branch_name }} </td>
                                    </tr>
                                    @endif

                                    @if(@$payment->frompayment->mobile)
                                    <tr>
                                        <td><b>{{ ___('Mobile') }}</b></td>
                                        <td>{{ @$payment->frompayment->mobile }} </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td><b>{{ ___('label.date')}}</b></td>
                                        <td> {{ dateFormat(@$payment->created_at) }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ ___('label.status') }}</b></td>
                                        <td> {!! @$payment->myStatus !!}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">
                                @if($payment->receipt !==null)
                                <a href="{{asset($payment->upload->original) }}" download="receipt">
                                    <span class="btn btn-outline-success mx-2"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download_receipt') }} </span>
                                </a>
                                @endif

                                <span class="btn btn-outline-danger mt-2"> <b>{{ ___('label.amount')}}</b> : {{ settings('currency') }} {{ @$payment->amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        @if ( count(@$payment->parcelPivot))
        <div class="col-md-6 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table  ">
                            <thead class="bg">
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('parcel.tracking_id') }}</th>
                                <th>{{ ___('parcel.cash_collection') }}</th>
                                <th>{{ ___('parcel.delivery_charge') }}</th>
                                <th>{{ ___('label.payable') }}</th>
                                <th>{{ ___('parcel.delivery_date') }}</th>
                            </thead>

                            <tbody>
                                @foreach (@$payment->parcelPivot as $pivot)
                                <tr>
                                    <td> {{ @$loop->iteration }}</td>
                                    <td> <a href="{{ route('parcel.details', $pivot->parcel->id) }}"> {{ $pivot->parcel->tracking_id }} </a></td>
                                    <td> {{ @$pivot->parcel->parcelTransaction->cash_collection}} </td>
                                    <td> {{ @$pivot->parcel->parcelTransaction->total_charge}}</td>
                                    <td> {{ @$pivot->parcel->parcelTransaction->cash_collection - @$pivot->parcel->parcelTransaction->total_charge}} </td>
                                    <td> {{ $pivot->parcel->delivery_date }} </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(@$payment->description)
        <div class="col-md-6 col-lg-4">
            <div class="j-eml-card">
                <h5 class="heading-5 mb-0 px-4">{{ ___('label.description') }}</h5>
                <div class="card-body p-4">
                    <p class="mb-0">{{@$payment->description}}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
<!-- nd wrapper  -->
@endsection()
