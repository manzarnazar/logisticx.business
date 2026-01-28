@extends('backend.partials.master')
@section('title')
{{ ___('parcel.express_pickup_request') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('parcel.express') }}</a></li>
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
                    <h4 class="title-site">{{ ___('parcel.express') }} {{ ___('parcel.pickup_request') }}</h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.merchant')}}</th>
                                    <th>{{ ___('label.name')}}</th>
                                    <th>{{ ___('label.phone')}}</th>
                                    <th>{{ ___('label.address')}}</th>
                                    <th>{{ ___('label.cod')}}</th>
                                    <th>{{ ___('label.invoice')}}</th>
                                    <th>{{ ___('label.weight')}}</th>
                                    <th>{{ ___('label.exchange')}}</th>
                                    <th>{{ ___('label.note')}}</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($expresses as $key => $express)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td> {{@$express->merchant->business_name}} </td>
                                    <!--
                                    <td>
                                        <div class="d-flex gap-3">
                                            <div>
                                                 {{-- <img src="{{ getImage($express->merchant->user->upload, 'original','default-image-40x40.png' ) }}" alt="user" class="rounded h-50px object-fit-cover"> --}}
                                            </div>
                                            <div>
                                                <strong class=" mb-1"> {{@$express->merchant->business_name}}</strong>
                                                <span class="d-block mb-1"> {{@$express->merchant->user->email}} </span>
                                                <span class="d-block"> {{@$express->merchant->user->mobile}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    -->
                                    <td>{{@$express->name}}</td>
                                    <td>{{@$express->phone}}</td>
                                    <td>{{@$express->address}}</td>
                                    <td class="whitespace-nowrap">{{ settings('currency') . " " . $express->cod_amount }}</td>
                                    <td>#{{@$express->invoice}}</td>
                                    <td>{{@$express->weight . " " . ___('label.kg')}}</td>
                                    <td>{!! @$express->exchange_badge !!}</td>
                                    <td>{{\Str::limit(@$express->note, 100, '...')}}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="10" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- pagination component -->
                    @if(count($expresses))
                    <x-paginate-show :items="$expresses" />
                    @endif
                    <!-- pagination component -->
                </div>
            </div>
        </div>
        <!-- end table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
