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
                            <li class="breadcrumb-item"><a href="{{route('merchant-panel.parcel.index')}}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.details')}}</a></li>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <p class="h4">{{ ___('invoice.invoice') }} : #{{ @$parcel->invoice_no }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="h4">{{ ___('label.cash_on_delivery') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table    table-sm">
                                    <tbody>
                                        <tr>
                                            <td>{{ ___('label.delivery_fee')}}</td>
                                            <td>{{ settings('currency') }} {{@number_format(($parcel->total_delivery_amount - $parcel->cod_amount),2)}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.cod')}}</td>
                                            <td>{{@$parcel->cod_amount}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{ ___('label.total_cost')}}</strong></td>
                                            <td><strong>{{ settings('currency') }} {{@$parcel->total_delivery_amount}}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="h4">{{ ___('label.delivery_info') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table    table-sm">
                                    <tbody>
                                        <tr>
                                            <td>{{ ___('label.delivery_type')}}</td>
                                            <td>
                                                {{ @$parcel->delivery_type_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.weight')}}</td>
                                            <td>{{@$parcel->weight}} {{@$parcel->deliveryCategory->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.amount_to_collect')}}</td>
                                            <td>{{@$parcel->cash_collection}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="h4">{{ ___('label.sender_info') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table    table-sm">

                                    <tbody>
                                        <tr>
                                            <td>{{ ___('label.business_name')}}</td>
                                            <td>
                                                {{ @$parcel->merchant->business_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.mobile')}}</td>
                                            <td> {{@$parcel->merchant->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.email')}}</td>
                                            <td>{{@$parcel->merchant->user->email}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="h4">{{ ___('label.recipient_info') }}</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table  table-sm">
                                    <tbody>
                                        <tr>
                                            <td>{{ ___('label.name')}}</td>
                                            <td>
                                                {{ @$parcel->customer_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.phone')}}</td>
                                            <td> {{@$parcel->customer_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ ___('label.address')}}</td>
                                            <td>{{@$parcel->customer_address}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
