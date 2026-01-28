{{-- not in use any more  --}}

@extends('backend.partials.master')
@section('title')
{{ ___('parcel.parcel') }} {{ ___('label.import') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant-panel.parcel.index') }}" class="breadcrumb-link">{{ ___('parcel.parcel') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('parcel.import') }}</a></li>
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
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-6">
                        <p class="h3">{{ ___('parcel.parcel_import') }}</p>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('parcel.importSample') }}" download class="btn btn-success btn-sm float-right" data-toggle="tooltip" data-placement="top" title="download">{{ ___('parcel.sample') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-10 mb-5">
                                <p>{{ ___('merchant.note') }}</p>
                                <ul class="list list-sm list-success">
                                    <li>{{ ___('merchant.01') }}</li>
                                    <li>{{ ___('merchant.02') }}</li>
                                    <li>{{ ___('merchant.03') }}</li>
                                    <li>{{ ___('merchant.04') }}: @foreach($productCategories as $category) @if($loop->last){{ $category->product_category_id }}={{ $category->productCategory->name }} @else {{ $category->product_category_id }}={{ $category->productCategory->name }},@endif @endforeach</li>
                                    <li>{{ ___('merchant.05') }}: @foreach(trans('deliveryType') as $key => $status) @if($loop->last){{ $key }}={{ $status }} @else {{ $key}}={{ $status }},@endif @endforeach</li>
                                    <li>{{ ___('merchant.06') }}</li>
                                    <li class="list-style-none mt-2">
                                        <form action="{{ route('merchant-panel.parcel.file-import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group ">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile">
                                                        </div>
                                                        @error('file')
                                                        <div class="text-danger ">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <button class="btn btn-primary form-control">{{ ___('parcel.import') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 ">
                            @if(session()->has('importErrors'))
                            <h2 class="text-center border-bottom">{{ ___('parcel.validation_log')}}</h2>
                            @foreach(session()->get('importErrors') as $key => $values)
                            <div class="text-primary ">{{ ___('parcel.in_row_number')}} : {{ $key }}</div>
                            @foreach($values as $value)
                            <div class="text-danger ">{{ $value }}</div>
                            @endforeach
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
<!-- js  -->
@push('scripts')
<script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush
