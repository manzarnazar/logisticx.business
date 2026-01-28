@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.view') }}
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
                            <li class="breadcrumb-item"><a href="{{route('expense.index')}}" class="breadcrumb-link">{{ ___('account.expense') }}</a></li>
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
                            <a href="{{route('support.add')}}" class="btn btn-outline-info"> {{ ___('label.open_ticket') }} </a>
                            <a href="{{ route('expense.edit', $expense->id) }}" class="btn btn-outline-primary"> <i class="fas fa-edit"></i> {{ ___('label.edit') }}</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between  mb-3">
                        <div>
                            <table class="table table-sm mb-1">
                                <tbody>

                                    <tr>
                                        <td> <b>{{ ___('label.account_head')}}</b>: </td>
                                        <td> {{ @$expense->accountHead->name }}</td>
                                    </tr>

                                    @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayDeliveryManCommission || @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayToHub || @$expense->account_head_id == \App\Enums\FixedAccountHeads::PaidToMerchant )

                                    <tr>

                                        @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayDeliveryManCommission )
                                        <td> <b>{{ ___('label.delivery_man')}}</b>: </td>
                                        <td> {{ @$expense->deliveryMan->user->name }}</td>
                                        @endif

                                        @if(@$expense->account_head_id == \App\Enums\FixedAccountHeads::PaidToMerchant)
                                        <td> <b>{{ ___('label.merchant_name')}}</b>: </td>
                                        <td> {{ @$expense->merchant->business_name }}</td>
                                        @endif


                                        @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayToHub )
                                        <td> <b>{{ ___('label.hub')}}</b>: </td>
                                        <td> {{ @$expense->hub->name }}</td>
                                        @endif

                                    </tr>

                                    <tr>
                                        <td> <b>{{ ___('label.address')}}</b>: </td>
                                        @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayDeliveryManCommission )
                                        <td>{{ @$expense->deliveryMan->user->address }}</td>
                                        @endif

                                        @if(@$expense->account_head_id == \App\Enums\FixedAccountHeads::PaidToMerchant)
                                        <td>{{ @$expense->merchant->address }}</td>
                                        @endif

                                        @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayToHub)
                                        <td>{{ @$expense->hub->address }}</td>
                                        @endif
                                    </tr>

                                    <tr>
                                        <td> <b>{{ ___('label.mobile_number')}}</b>: </td>
                                        @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayDeliveryManCommission )
                                        <td>{{ @$expense->deliveryMan->user->mobile }}</td>
                                        @endif

                                        @if(@$expense->account_head_id == \App\Enums\FixedAccountHeads::PaidToMerchant)
                                        <td> {{ @$expense->merchant->user->mobile }}</td>
                                        @endif

                                        @if(@$expense->account_head_id == \App\Enums\FixedAccountHeads::PayToHub)
                                        <td> {{ @$expense->hub->phone }}</td>
                                        @endif
                                    </tr>

                                    @if( @$expense->account_head_id == \App\Enums\FixedAccountHeads::PayToHub )
                                    <tr>
                                        <td> <b>{{ ___('label.account_name')}}</b>: </td>
                                        <td> {{ @$expense->hubAccount->account_holder_name }}</td>
                                    </tr>
                                    <tr>
                                        <td> <b>{{ ___('label.account_number')}}</b>: </td>
                                        <td> {{ @$expense->hubAccount->account_no }}</td>
                                    </tr>
                                    @endif

                                    @else
                                    <tr>
                                        <td> <b>{{ ___('label.title')}}</b>: </td>
                                        <td> {{ @$expense->title }}</td>
                                    </tr>
                                    @endif


                                </tbody>
                            </table>
                        </div>

                        <div>
                            <table class="table table-sm table-bordered border-primary">
                                <tbody>

                                    @if(@$expense->account->account_holder_name)
                                    <tr>
                                        <td><b>{{ ___('label.account_name') }}</b></td>
                                        <td>{{ @$expense->account->account_holder_name }} </td>
                                    </tr>
                                    @endif

                                    @if(@$expense->account->account_no)
                                    <tr>
                                        <td><b>{{ ___('label.account_number') }}</b></td>
                                        <td>{{ @$expense->account->account_no }} </td>
                                    </tr>
                                    @endif

                                    @if(@$expense->account->branch_name)
                                    <tr>
                                        <td><b>{{ ___('Branch') }}</b></td>
                                        <td>{{ @$expense->account->branch_name }} </td>
                                    </tr>
                                    @endif

                                    @if(@$expense->account->mobile)
                                    <tr>
                                        <td><b>{{ ___('Mobile') }}</b></td>
                                        <td>{{ @$expense->account->mobile }} </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <td><b>{{ ___('label.date')}}</b></td>
                                        <td> {{ dateFormat(@$expense->created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-end">

                                @if($expense->receipt !==null)
                                <a href="{{asset($expense->upload->original) }}" download="receipt">
                                    <span class="btn btn-outline-success mx-2"> <i class="fa-solid fa-cloud-arrow-down"></i> {{ ___('label.download_receipt') }} </span>
                                </a>
                                @endif

                                <span class="btn btn-outline-danger"> <b>{{ ___('label.amount')}}</b> : {{ settings('currency') }} {{ @$expense->amount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">

        @if ( count(@$expense->heroCommissions))
        <div class="col-8">
            <div class="card p-0">
                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table  ">
                            <thead class="bg">
                                <th>{{ ___('label.id') }}</th>
                                <th>{{ ___('parcel.tracking_id') }}</th>
                                <th>{{ ___('parcel.delivery_date') }}</th>
                                <th>{{ ___('label.hero_commission') }}</th>
                                <th>{{ ___('label.payment_status') }}</th>
                            </thead>

                            <tbody>
                                @foreach (@$expense->heroCommissions as $commission)
                                <tr>
                                    <td> {{ @$loop->iteration }}</td>
                                    <td> <a href="{{ route('parcel.details', $commission->parcel_id) }}"> {{ $commission->parcel->tracking_id }} </a></td>
                                    <td> {{ $commission->parcel->delivery_date }} </td>
                                    <td> {{ $commission->amount}}</td>
                                    <td> {!! $commission->commission_payment_status !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(@$expense->note)
        <div class="col-4">
            <div class="j-eml-card">
                <h5 class="heading-5">{{ ___('label.note') }}</h5>
                <div class="card-body mx-3">
                    <p>{{@$expense->note}}</p>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
<!-- nd wrapper  -->
@endsection()
