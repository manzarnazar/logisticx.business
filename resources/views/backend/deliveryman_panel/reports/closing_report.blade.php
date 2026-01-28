@extends('backend.partials.master')
@section('title')
{{ ___('menus.closing_report') }}
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('menus.closing_report') }}</a></li>
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
            <div class="card mb-3">
                <div class="card-body">
                    <form action="{{route('deliveryman.panel.reports.closing.report')}}" method="get">
                        {{-- @csrf --}}

                        <div class=" form-row">
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="text" placeholder= "{{___('placeholder.enter_date_range')}}" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ old('date',request()->input('date')) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-4 d-flex align-items-end">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{route('deliveryman.panel.reports.closing.report')}}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>

                                @if(@$report)
                                <a href="{{ route('deliveryman.panel.reports.closing.report', ['print'=> true, 'date' => request()->date ]) }}" class="j-td-btn" target="_blank"> <i class="fa-solid fa-print"></i> <span>{{ ___('label.print') }}</span> </a>
                                @endif

                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if( @$report)
            @include('backend.reports.panel.deliveryman',['col'=>'col-md-6'])
            @endif

        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
