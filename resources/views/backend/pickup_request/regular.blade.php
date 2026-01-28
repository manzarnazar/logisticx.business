@extends('backend.partials.master')
@section('title')
{{ ___('parcel.regular') }} {{ ___('parcel.pickup_request') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('parcel.pickup_request') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('parcel.regular') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- table  -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('parcel.regular') }} {{ ___('parcel.pickup_request') }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.merchant')}}</th>
                                    <th>{{ ___('label.address')}}</th>
                                    <th>{{ ___('label.estimated_parcel')}}</th>
                                    <th>{{ ___('label.note')}}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($regulars as $key => $regular)
                                <tr>

                                    <td>{{ ++$key }}</td>
                                    <td> {{@$regular->merchant->business_name}} </td>
                                    <td>{{@$regular->address}}</td>
                                    <td>{{@$regular->parcel_quantity}}</td>
                                    <td>{{\Str::limit(@$regular->note, 100, '...')}}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($regulars))
                    <x-paginate-show :items="$regulars" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end wrapper  -->
@endsection()
