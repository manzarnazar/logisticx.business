@extends('backend.partials.master')
@section('title')
{{ ___('account.fund_transfer') }} {{ ___('label.add') }}
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('fund-transfer.index') }}" class="breadcrumb-link">{{ ___('menus.fund_transfer') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ ___('label.create') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('label.create') }} {{ ___('account.fund_transfer') }}</h4>
                    </div>
                    <form action="{{route('fund-transfer.store')}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="from_account">{{ ___('label.from_account') }}<span class="text-danger">*</span> </label>
                                <select id="from_account" name="from_account" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.from_account') }}</option>
                                    @foreach($accounts as $account)
                                    @if( $account->gateway == 1 )
                                    <option {{ (old('from_account') == $account->id) ? 'selected' : '' }} value="{{ $account->id }}">{{$account->user->name}} (Cash)</option>
                                    @else
                                    <option {{ (old('from_account') == $account->id) ? 'selected' : '' }} value="{{ $account->id }}">
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
                                    <option {{ (old('to_account') == $account->id) ? 'selected' : '' }} value="{{ $account->id }}">{{ $account->user->name }} (Cash)</option>
                                    @else
                                    <option {{ (old('to_account') == $account->id) ? 'selected' : '' }} value="{{ $account->id }}">
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
                                <label class="label-style-1" for="date">{{ ___('label.date') }}<span class="text-danger">*</span> </label>
                                <input type="date" readonly="readonly" name="date" data-parsley-trigger="change" placeholder="Enter Date" autocomplete="off" class="form-control input-style-1 flatpickr" value="{{old('date',date('Y-m-d'))}}" require>
                                @error('date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="amount">{{ ___('label.amount') }}<span class="text-danger">*</span> </label>
                                <input type="number" id="amount" name="amount" data-parsley-trigger="change" placeholder="{{ ___('placeholder.enter_Amount') }}" autocomplete="off" class="form-control input-style-1" value="{{old('amount')}}" require>
                                @error('amount')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                                <div class="check_message"></div>
                                <p class="active h6" id="currentBalanceText">{{ ___('label.current_balance')}}:</p> <span class="active h6" id="currentBalance"></span>
                                <input type="hidden" placeholder="{{ ___('placeholder.current_balance') }}" id="current_balance" name="current_balance" value="{{old('current_balance')}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label class="label-style-1" for="description">{{ ___('label.description') }}</label>
                                <textarea id="description" placeholder="{{ ___('placeholder.enter_description') }}" name="description" class="form-control input-style-1">{{old('description')}}</textarea>
                            </div>

                        </div>

                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.save') }}</span></button>
                                <a href="{{ route('fund-transfer.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }} </span></a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- end basic form -->
    </div>
</div>
@endsection()

@push('scripts')
<script src="{{ asset('backend/js/custom/fund_transfer/custom.js') }}"></script>
@endpush
