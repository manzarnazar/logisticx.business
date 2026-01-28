@extends('backend.partials.master')
@section('title')
{{ ___('menus.account_transaction') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('merchant.accounts.account-transaction.index') }}" class="breadcrumb-link">{{ ___('menus.account_transaction') }}</a></li>
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
                    <form action="{{route('merchant.accounts.account-transaction.filter')}}" method="POST">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12 col-md-4 ">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="date" autocomplete="off" id="date" name="date" class="form-control input-style-1  flatpickr-range" value="{{ isset(request()->date) ? request()->date : old('date') }}" placeholder="{{ ___('merchant.date') }}">
                                @error('date') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1 for=" type">{{ ___('label.type') }}</label>
                                <select name="type" id="type" class="form-control select2">
                                    <option value="" selected>{{ ___('merchant.type') }}</option>
                                    @foreach(config('site.account_head') as $key => $value)
                                    <option value="{{ $key }}" @selected(old('type',request()->type) == $key ) >{{ ___("account.{$value}")}}</option>
                                    @endforeach
                                </select>
                                @error('type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1 for=" account">{{ ___('label.account') }}</label>
                                <select name="account" id="account_id" class="form-control select2">
                                    <option> </option>
                                    @foreach ($accounts as $account)
                                    <option value="{{$account->id}}" @selected(old('account',request()->account) == $account->id ) >{{$account->text}} </option>
                                    @endforeach
                                </select>
                                @error('account') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12 col-md-4 j-create-btns">
                                <div class="drp-btns ">
                                    <button type="submit" class="j-td-btn"><i class="fa fa-filter"></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('merchant.accounts.account-transaction.index') }}" class="j-td-btn btn-red"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="card-header mb-4">
                    <h4 class="title-site">{{ ___('menus.account_transaction') }} </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table    ">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('merchant.transaction_id') }}</th>
                                    <th>{{ ___('merchant.amount') }}</th>
                                    <th>{{ ___('label.type') }}</th>
                                    <th>{{ ___('label.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$transaction->merchantPayment->transaction_id}}</td>
                                    <td>{{settings('currency')}}{{$transaction->amount}}</td>
                                    <td>{{$transaction->TransactionOppositeType }} </td>
                                    <td>{{ dateFormat($transaction->created_at) }} </td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="5" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($transactions))
                <x-paginate-show :items="$transactions" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>
        <!-- end data table  -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()
