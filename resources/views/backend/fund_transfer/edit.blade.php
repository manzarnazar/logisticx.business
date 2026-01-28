@extends('backend.partials.master')
@section('title')
{{ ___('account.fund_transfer') }} {{ ___('label.edit') }}
@endsection
@section('maincontent')
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
                            <li class="breadcrumb-item"><a href="{{ route('fund-transfer.index') }}" class="breadcrumb-link">{{ ___('account.fund_transfer') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.edit') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- end pageheader -->
    <div class="row">
        <!-- basic form -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-input-header">
                        <h4 class="title-site"> {{ ___('label.edit') }} {{ ___('account.fund_transfer') }}</h4>
                    </div>
                    <form action="{{route('fund-transfer.update',$fund_transfer->id)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="from_account">{{ ___('label.from_account') }}<span class="text-danger">*</span> </label>
                                <select id="from_account" name="from_account" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.from_account') }}</option>
                                    @foreach($accounts as $account)
                                    @if( $account->gateway == 1 )
                                    <option {{ $fund_transfer->from_account == $account->id ? 'selected' : '' }} value="{{ $account->id }}">{{$account->user->name}} (Cash)</option>
                                    @else
                                    <option {{ $fund_transfer->from_account == $account->id ? 'selected' : '' }} value="{{ $account->id }}">
                                        @if($account->gateway == 3)
                                        bKash ,
                                        @elseif ($account->gateway == 4)
                                        Rocket ,
                                        @elseif ($account->gateway == 5)
                                        Nagad ,
                                        @endif
                                        {{$account->account_holder_name}}
                                        ({{$account->account_no}}
                                        {{$account->branch_name}}
                                        {{$account->mobile}})
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('from_account')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="to_account">{{ ___('label.to_account') }}<span class="text-danger">*</span> </label>
                                <select id="to_account" name="to_account" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.to_account') }}</option>
                                    @foreach($accounts as $account)
                                    @if( $account->gateway == 1 )
                                    <option {{ $fund_transfer->to_account == $account->id ? 'selected' : '' }} value="{{ $account->id }}">{{$account->user->name}} (Cash)</option>
                                    @else
                                    <option {{ $fund_transfer->to_account == $account->id ? 'selected' : '' }} value="{{ $account->id }}">
                                        @if($account->gateway == 3)
                                        bKash ,
                                        @elseif ($account->gateway == 4)
                                        Rocket ,
                                        @elseif ($account->gateway == 5)
                                        Nagad ,
                                        @endif
                                        {{$account->account_holder_name}}
                                        ({{$account->account_no}}
                                        {{$account->branch_name}}
                                        {{$account->mobile}})
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('to_account')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="amount">{{ ___('label.amount') }}<span class="text-danger">*</span> </label>
                                <input type="text" id="amount" name="amount" data-parsley-trigger="change" placeholder="{{ ___('placeholder.Enter_Amount') }}" autocomplete="off" class="form-control input-style-1" value="{{$fund_transfer->amount}}" require>
                                @error('amount')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                                <div class="check_message"></div>
                                <span class="active h6">{{ ___('label.current_balance')}}</span>: <span class="active h6" id="currentBalance"></span>
                                <input type="hidden" id="current_balance" name="current_balance" value="{{$current_balance}}">
                                <input type="hidden" id="old_amount" name="old_amount" value="{{$fund_transfer->amount}}">
                                <input type="hidden" id="old_from_account" name="old_from_account" value="{{$fund_transfer->from_account}}">
                                <input type="hidden" id="old_to_account" name="old_to_account" value="{{$fund_transfer->to_account}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                                <input type="date" readonly="readonly" name="date" data-parsley-trigger="change" placeholder="yyyy-mm-dd" autocomplete="off" class="form-control input-style-1 flatpickr" value="{{$fund_transfer->date}}" require>
                                @error('date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="description">{{ ___('label.description') }}</label>
                                <textarea id="description" placeholder="{{ ___('placeholder.Enter_description') }}" name="description" class="form-control input-style-1">{{$fund_transfer->description}}</textarea>
                            </div>

                        </div>

                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('fund-transfer.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
<!-- end wrapper  -->
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/fund_transfer/custom.js') }}"></script>
@endpush
