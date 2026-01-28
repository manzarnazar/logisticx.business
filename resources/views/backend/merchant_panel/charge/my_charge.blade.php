@extends('backend.partials.master')
@section('title')
{{ ___('charges.my_charge_list') }}
@endsection
@section('maincontent')
<!-- wrapper  -->
<div class="container-fluid  dashboard-content">
    <!-- pageheader -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 cpol-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('label.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link">{{ ___('charges.charge') }}</a></li>
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
                    <h4 class="title-site">{{ ___('charges.my_charge_list') }} </h4>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('charges.product') }}</th>
                                    <th>{{ ___('charges.service') }}</th>
                                    <th>{{ ___('charges.area') }}</th>
                                    <th>{{ ___('charges.time') }}</th>
                                    <th>{{ ___('charges.reguler') }}</th>
                                    <th>{{ ___('charges.additional') }}</th>
                                    <th>{{ ___('charges.return') }}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($charges as $key => $charge)

                                <tr id="row_{{ $charge->id }}">
                                    <td>{{ $key + 1}}</td>
                                    <td>{{$charge->productCategory->name}}</td>
                                    <td>{{$charge->serviceType->name}}</td>
                                    <td>{{ ___('charges.'.$charge->area) }}</td>
                                    <td>{{$charge->delivery_time}} Hour</td>
                                    <td>{{settings('currency') . " " . $charge->charge}}</td>
                                    <td>{{settings('currency') . " " . $charge->additional_charge}}</td>
                                    <td>{{ @$charge->generalCharge->return_charge }} %</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="8" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($charges))
                <x-paginate-show :items="$charges" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()


@push('scripts')
@include('backend.partials.delete-ajax')
@endpush
