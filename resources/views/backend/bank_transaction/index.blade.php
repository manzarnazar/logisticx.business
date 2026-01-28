@extends('backend.partials.master')
@section('title')
{{ ___('menus.bank_transaction') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bank-transaction.index') }}" class="breadcrumb-link">{{ ___('menus.bank_transaction') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ ___('label.list') }}</a></li>
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
                <div class="card-body">
                    <form action="{{route('bank-transaction.filter')}}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12  col-sm-6 col-md-3">
                                <label class="label-style-1" for="date">{{ ___('parcel.date') }}</label>
                                <input type="text" autocomplete="off" id="date" name="date" class="form-control input-style-1 flatpickr-range" placeholder= "{{___('placeholder.enter_date_range')}}" value="{{ isset($request->date) ? $request->date : old('date') }}">
                                @error('date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-3">
                                <label class="label-style-1" for="type">{{ ___('label.type') }}</label>
                                <select name="type" class="form-control input-style-1 select2">
                                    <option value="" selected>{{ ___('merchant.type') }}</option>
                                    @foreach(config('site.account_head') as $key => $value)
                                    <option value="{{ $value }}" {{ (isset($request->type) ? $request->type : old('type')) == $value ? 'selected' : '' }}>{{ ___('AccountHeads.'.$value)}}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-3 ">
                                <label class="label-style-1" for="account_head_id">{{ ___('label.account_heads') }}</label>
                                <select id="account_head_id" name="account_head_id" class="form-control input-style-1 select2" data-account-balance-url="{{ route('accounts.current-balance') }}">
                                    <option value="0" selected disabled>{{ ___('menus.select') }} {{ ___('label.account_heads') }}</option>
                                    @foreach ($accountHeads as $head)
                                    <option value="{{ $head->id }}" @selected((old('account_head_id',$request->account_head_id)==$head->id) ) > {{ $head->name }} </option>
                                    @endforeach
                                </select>
                                <small class="text-danger errorTextBox d-none mt-2" data-error-for="account_head_id"></small>
                            </div>

                            <div class="form-group col-12 col-sm-6 col-md-3">
                                <label class="label-style-1" for="account">{{ ___('label.account') }}</label>
                                <select name="account" class="form-control input-style-1 select2">
                                    <option value="" selected>{{ ___('merchant.account') }} </option>
                                    @foreach ($accounts as $account)
                                    @if ($account->type == App\Enums\AccountType::ADMIN)
                                    <option value="{{$account->id}}" {{ ((isset($request->account) ? $request->account : old('account')) == $account->id) ? 'selected' : '' }}>
                                        @if ($account->gateway == 1)
                                        {{ $account->user->name }} | {{ ___('merchant.cash') }}
                                        @else
                                        {{$account->account_no}} | ({{$account->account_holder_name}})
                                        @endif
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('account')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 col-md-4 ">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('bank-transaction.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="card-header mb-3">
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-item-center">
                            <h4 class="title-site">{{ ___('menus.bank_transaction') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.name')}} | {{ ___('label.account_no') }} </th>
                                    <th>{{ ___('label.type') }}</th>
                                    <th>{{ ___('label.amount') }}</th>
                                    <th>{{ ___('label.date') }}</th>
                                    <th>{{ ___('label.note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $n = 0;
                                @endphp
                                @forelse ($transactions as $transaction)
                                <tr>
                                    <td>{{++$n}}</td>

                                    <td> {{ $transaction->account->account_holder_name }} | {{ $transaction->account->account_no }} </td>

                                    <td>{!! $transaction->account_type !!}</td>
                                    <td>{{ @settings('currency') }}{{$transaction->amount}}</td>
                                    <td>{{dateTimeFormat($transaction->date)}}</td>
                                    <td>{{$transaction->note}}</td>
                                </tr>
                                @empty
                                <x-nodata-found :colspan="7" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- pagination component -->
                @if(count($transactions))
                <x-paginate-show :items="$transactions" />
                @endif
                <!-- end pagination component -->
            </div>
        </div>

    </div>
</div>
<!-- end wrapper  -->

@endsection()
