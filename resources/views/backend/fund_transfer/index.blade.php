@extends('backend.partials.master')
@section('title')
{{ ___('account.fund_transfer') }} {{ ___('label.list') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('menus.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('fund-transfer.index')}}" class="breadcrumb-link">{{ ___('account.fund_transfer') }}</a></li>
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
                <div class="card-body">
                    <form action="{{route('fund.transfer.filter')}}" method="GET">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="parcel_date">{{ ___('parcel.date') }}</label>
                                <input type="date" autocomplete="off" id="date" name="date" placeholder="{{___('placeholder.enter_date_range')}}" class="form-control input-style-1 flatpickr-range" value="{{ old('parcel_date',$request->date) }}">
                            </div>


                            <div class="form-group col-md-4 col-12 ">
                                <label class="label-style-1" for="from_account">{{ ___('label.from_account') }}</label>
                                <select id="from_account" name="from_account" class="form-control input-style-1 select2">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('label.from_account') }}</option>
                                    @foreach ($accounts as $account)
                                    @if ($account->gateway == 1)
                                    <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif>{{ $account->user->name }} | {{ ___('merchant.cash') }} : {{ $account->balance }} </option>
                                    @elseif($account->gateway == 3 || $account->gateway == 4 || $account->gateway == 5)
                                    <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif >{{$account->account_holder_name}} |No : {{ $account->mobile }}| @if($account->account_type == 1) {{ ___('merchant.merchant') }} @else {{ ___('placeholder.persional') }} @endif | {{ ___('merchant.current_balance') }}: {{ $account->balance }} </option>
                                    @else
                                    <option value="{{ $account->id }}" @if($request->from_account == $account->id) selected @endif >{{$account->account_holder_name}} | A.No : {{ $account->account_no }} | {{ ___('merchant.current_balance') }}: {{ $account->balance }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-4">
                                <label class="label-style-1" for="to_account">{{ ___('label.to_account') }}</label>
                                <select id="to_account" name="to_account" class="form-control input-style-1 select2">
                                    <option value=""> {{ ___('menus.select') }} {{ ___('label.to_account') }}</option>
                                    @foreach ($accounts as $account)
                                    @if ($account->gateway == 1)
                                    <option value="{{ $account->id }}" @if($request->to_account == $account->id) selected @endif>{{ $account->user->name }} | {{ ___('merchant.cash') }} : {{ $account->balance }} </option>
                                    @elseif($account->gateway == 3 || $account->gateway == 4 || $account->gateway == 5)
                                    <option value="{{ $account->id }}" @if($request->to_account == $account->id) selected @endif>{{$account->account_holder_name}} |No : {{ $account->mobile }}| @if($account->account_type == 1) {{ ___('merchant.merchant') }} @else {{ ___('placeholder.persional') }} @endif | {{ ___('merchant.current_balance') }}: {{ $account->balance }} </option>
                                    @else
                                    <option value="{{ $account->id }}" @if($request->to_account == $account->id) selected @endif>{{$account->account_holder_name}} | A.No : {{ $account->account_no }} | {{ ___('merchant.current_balance') }}: {{ $account->balance }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-2 col-12 col-xl-3 col-lg-4 col-md-6">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="j-td-btn mr-2"><i class="fa fa-filter "></i><span>{{ ___('label.filter') }}</span></button>
                                    <a href="{{ route('fund-transfer.index') }}" class="j-td-btn btn-red mr-2"><i class="fa fa-eraser"></i><span>{{ ___('label.clear') }}</span></a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">

                <div class="card-header mb-3">
                    <h4 class="title-site">{{ ___('account.fund_transfer') }} {{ ___('label.list') }}</h4>

                    <div class="col-4">
                        <form action="{{ route('fund.transfer.specific.search') }}" class="d-flex">
                            @csrf
                            <input id="Psearch" class="form-control input-style-1 parcelSearch group-input" value="{{ $request->search }}" name="search" type="text" placeholder={{___('placeholder.search')}}>
                            <button type="submit" class=" ml-1 j-td-btn">{{___('label.search')}}</button>
                            @if (isset($search) && count($search) > 0)
                            <a href="{{ route('fund.transfer.search.filter.print',['ids'=>$search]) }}" target="_blank" class="btn btn-primary ml-2">{{ ___('label.print') }}</a>
                            @endif
                        </form>
                    </div>

                    @if(hasPermission('fund_transfer_create') )
                    <a href="{{route('fund-transfer.create')}}" class="j-td-btn">
                        <img src="{{ asset('backend') }}/icons/icon/plus-white.png" class="jj" alt="no image"> <span>{{ ___('label.add') }} </span>
                    </a>
                    @endif

                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg">
                                <tr>
                                    <th>{{ ___('label.id') }}</th>
                                    <th>{{ ___('label.from_account') }}</th>
                                    <th>{{ ___('label.to_account') }}</th>
                                    <th>{{ ___('label.date') }}</th>
                                    <th>{{ ___('label.amount') }}</th>
                                    @if(hasPermission('fund_transfer_update') == true || hasPermission('fund_transfer_delete') == true )
                                    <th>{{ ___('label.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @forelse($fund_transfers as $fund_transfer)
                                <tr id="row_{{ $fund_transfer->id }}">
                                    <td>{{$i++}}</td>
                                    <td>
                                        <div class="row width300px">
                                            <div class="col-4">
                                                <img src="{{ getImage($fund_transfer->fromAccount->user->upload, 'original','default-image-40x40.png' ) }}" alt="Image" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="col-8">
                                                <strong> {{$fund_transfer->fromAccount->user->name}}</strong><br>
                                                <span> {{$fund_transfer->fromAccount->user->email}}</span><br>
                                            </div>
                                        </div>
                                        @if ($fund_transfer->fromAccount->gateway == 1)
                                        Cash
                                        @elseif ($fund_transfer->fromAccount->gateway == 2)
                                        {{-- Bank info --}}
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.bank')}}</div>
                                            <div class="col-8">: {{@$fund_transfer->fromAccount->bank->bank_name}} </div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.branch_name')}}</div>
                                            <div class="col-8">: {{$fund_transfer->fromAccount->branch_name}}</div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.account_no')}}</div>
                                            <div class="col-8">: {{$fund_transfer->fromAccount->account_no}}</div>
                                        </div>
                                        @elseif ($fund_transfer->fromAccount->gateway == 3)
                                        {{-- Mobile bank info --}}
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.mobile')}}</div>
                                            <div class="col-8">: {{$fund_transfer->fromAccount->mobile}}</div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.type')}}</div>
                                            <div class="col-8">:
                                                @if ($fund_transfer->fromAccount->account_type == 1)
                                                Merchant
                                                @else
                                                Personal
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.balance')}}</div>
                                            <div class="col-8">: {{settings('currency')}}{{$fund_transfer->fromAccount->balance}}</div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.opening_balance')}}</div>
                                            <div class="col-8">: {{settings('currency')}}{{$fund_transfer->fromAccount->opening_balance}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row width300px">
                                            <div class="col-4">
                                                <img src="{{ getImage($fund_transfer->toAccount->user->upload, 'original','default-image-40x40.png' ) }}" alt="Image" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="col-8">
                                                <strong> {{$fund_transfer->toAccount->user->name}}</strong><br>
                                                <span> {{$fund_transfer->toAccount->user->email}}</span><br>
                                            </div>
                                        </div>
                                        @if ($fund_transfer->toAccount->gateway == 1)
                                        <div class="row width300px">
                                            <div class="col-4">Payment method</div>
                                            <div class="col-8">: Cash
                                            </div>
                                        </div>
                                        @elseif ($fund_transfer->toAccount->gateway == 2)
                                        {{-- Bank info --}}
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.bank')}}</div>
                                            <div class="col-8">: {{@$fund_transfer->toAccount->bank->bank_name}} </div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.branch_name')}}</div>
                                            <div class="col-8">: {{$fund_transfer->toAccount->branch_name}}</div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.account_no')}}</div>
                                            <div class="col-8">: {{$fund_transfer->toAccount->account_no}}</div>
                                        </div>
                                        @elseif ($fund_transfer->toAccount->gateway == 3)
                                        {{-- Mobile bank info --}}
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.mobile')}}</div>
                                            <div class="col-8">: {{$fund_transfer->toAccount->mobile}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{ ___('label.type')}}</div>
                                            <div class="col-8">:
                                                @if ($fund_transfer->toAccount->account_type == 1)
                                                Merchant
                                                @else
                                                Personal
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.balance')}}</div>
                                            <div class="col-8">: {{settings('currency')}}{{$fund_transfer->toAccount->balance}}</div>
                                        </div>
                                        <div class="row width300px">
                                            <div class="col-4">{{ ___('label.opening_balance')}}</div>
                                            <div class="col-8">: {{settings('currency')}}{{$fund_transfer->toAccount->opening_balance}}</div>
                                        </div>
                                    </td>
                                    <td>{{dateTimeFormat($fund_transfer->date)}}</td>
                                    <td>{{settings('currency')}}{{$fund_transfer->amount}}</td>
                                    @if(hasPermission('fund_transfer_update') == true || hasPermission('fund_transfer_delete') == true )
                                    <td>
                                        <div class="d-flex" data-toggle="dropdown">
                                            <a class="p-2" href="javascript:void()">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </a>
                                        </div>
                                        <div class="dropdown-menu">
                                            @if(hasPermission('fund_transfer_update') == true)
                                            <a href="{{route('fund-transfer.edit',$fund_transfer->id)}}" class="dropdown-item"><i class="fa fa-edit" aria-hidden="true"></i> {{ ___('label.edit') }}</a>
                                            @endif
                                            @if(hasPermission('fund_transfer_delete') == true )
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="delete_row('admin/fund-transfer/delete', {{$fund_transfer->id}})">
                                                <i class="fa fa-trash" aria-hidden="true"></i> {{ ___('label.delete') }}
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <x-nodata-found :colspan="6" />
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if(count($fund_transfers))
                <x-paginate-show :items="$fund_transfers" />
                @endif

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
