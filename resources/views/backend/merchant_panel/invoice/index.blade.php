@extends('backend.partials.master')
@section('title')
{{ ___('menus.invoice') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.invoice') }}</a></li>
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
                    <h4 class="title-site"> {{ ___('menus.invoice') }} {{ ___('label.list') }}
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table  ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('menus.invoice') .' '. ___('invoice.id')}}</th>
                                    <th>{{ ___('menus.invoice') . ' '. ___('label.date')}}</th>
                                    <th>{{ ___('parcel.Total_Charge')}}</th>
                                    <th>{{ ___('parcel.cash_collection')}}</th>
                                    <th>{{ ___('parcel.current_payable')}}</th>
                                    <th>{{ ___('parcel.status')}}</th>
                                    <th>{{ ___('label.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $i=0;
                                @endphp
                                @forelse ($invoices as $invoice)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{@$invoice->invoice_id}}</td>
                                    <td>{{@$invoice->invoice_date}}</td>
                                    <td>{{ settings('currency') }}{{@$invoice->total_charge}}</td>
                                    <td>{{ settings('currency') }}{{@$invoice->cash_collection}}</td>
                                    <td>{{ settings('currency') }}{{@$invoice->current_payable}}</td>
                                    <td>{!! $invoice->my_status !!}</td>
                                    <td>
                                        <a href="{{ route('merchant.panel.invoice.details',$invoice->invoice_id) }}" class="btn btn-sm btn-primary mt-1"><i class="fa fa-eye"></i> View</a>
                                        <a href="{{ route('merchant.panel.invoice.csv',[$invoice->merchant_id,$invoice->invoice_id]) }}" class="btn btn-sm btn-success mt-1"><i class="fa fa-download"></i> CSV</a>
                                    </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="8" />
                                @endforelse
                                <tr>
                            </tbody>
                        </table>
                    </div>
                    <!--  pagination component -->
                    @if(count($invoices))
                    <x-paginate-show :items="$invoices" />
                    @endif
                </div>

            </div>
        </div>
    </div>



</div>
<!-- end wrapper  -->
@endsection()
