@extends('backend.partials.master')
@section('title', ___('reports.title') . ' | ' . ___('reports.closing') )
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ ___('reports.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.reports') }}" class="breadcrumb-link active">{{ ___('reports.closing') }}</a></li>
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
                    <form action="{{route('reports.closing')}}" method="GET">
                        {{-- @csrf --}}

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="date" placeholder= "{{ ___('placeholder.enter_date_range') }}" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ old('date',request()->input('date')) }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-4 d-flex align-items-end">
                                <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                <a href="{{ route('reports.closing') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>

                                @if(@$report)
                                <a href="{{ route('reports.closing',['print'=> true,'date'=>request()->date]) }}" class="j-td-btn" target="_blank"> <i class="fa-solid fa-print"></i> {{ ___('reports.print') }}</a>
                                @endif

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(@$report)
    @include('backend.reports.closing.report')
    @endif

</div>

<!-- end wrapper  -->


@endsection()
