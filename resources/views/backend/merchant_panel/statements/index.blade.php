@extends('backend.partials.master')
@section('title')
{{ ___('menus.statements') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.accounts.statements.index') }}" class="breadcrumb-link">{{ ___('menus.statements') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
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
                <div class="card-body">
                    <form action="{{route('merchant.accounts.statements.filter')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="date" autocomplete="off" id="date" name="date" class="form-control input-style-1 flatpickr-range" value="{{ isset($request->date) ? $request->date : old('date') }}" placeholder="{{ ___('merchant.date') }}">
                                @error('date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="type">{{ ___('label.type') }}</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected>{{ ___('merchant.type') }}</option>
                                    <option value="{{ \App\Enums\AccountHeads::INCOME }}" {{ (isset($request->type) ? $request->type : old('type')) == \App\Enums\AccountHeads::INCOME ? 'selected' : '' }}>{{ ___('AccountHeads.'.\App\Enums\AccountHeads::INCOME)}}</option>
                                    <option value="{{ \App\Enums\AccountHeads::EXPENSE }}" {{ (isset($request->type) ? $request->type : old('type')) == \App\Enums\AccountHeads::EXPENSE ? 'selected' : '' }}>{{ ___('AccountHeads.'.\App\Enums\AccountHeads::EXPENSE)}}</option>
                                </select>
                                @error('type')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_tracking_id">{{ ___('label.track_id')}}</label>
                                <input id="parcel_tracking_id" type="text" name="parcel_tracking_id" placeholder="{{ ___('merchant.tracking_id') }}" class="form-control input-style-1" value="{{ old('parcel_tracking_id',isset($request->parcel_tracking_id) ? $request->parcel_tracking_id:'') }}">
                                @error('parcel_tracking_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-4 j-create-btns">
                                <div class="drp-btns ">
                                    <button type="submit" class="j-td-btn"><i class="fa fa-filter"></i>
                                    <span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('merchant.accounts.statements.index') }}" class="j-td-btn btn-red"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-header mb-4">
                        <h4 class="title-site">{{ ___('menus.statements') }}
                        </h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('accounts.details') }}</th>
                                    <th>{{ ___('accounts.date') }}</th>
                                    <th>{{ ___('label.type') }}</th>
                                    <th>{{ ___('accounts.amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($statements as $statement)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <div class="w150">
                                            {{ $statement->note }}<br />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="w150">
                                            {{ dateFormat($statement->date)}}
                                        </div>
                                    </td>
                                    <td>
                                        @if($statement->type == \App\Enums\AccountHeads::INCOME)
                                        <span class="badge badge-pill badge-success">{{trans('AccountHeads.'.\App\Enums\AccountHeads::INCOME) }}</span>
                                        @elseif($statement->type == \App\Enums\AccountHeads::EXPENSE)
                                        <span class="badge badge-pill badge-danger">{{trans('AccountHeads.'.\App\Enums\AccountHeads::EXPENSE) }}</span>
                                        @endif
                                    </td>
                                    <td class="@if($statement->type == \App\Enums\AccountHeads::INCOME) text-success @else text-danger @endif">{{settings('currency')}}{{number_format($statement->amount,2)}}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($statements))
                <x-paginate-show :items="$statements" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
