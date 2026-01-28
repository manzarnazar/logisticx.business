@extends('backend.partials.master')
@section('title')
{{ ___('account.accounts') }} {{ ___('label.edit') }}
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
                            <li class="breadcrumb-item"><a href="{{ route('accounts.index') }}" class="breadcrumb-link">{{ ___('account.accounts') }}</a></li>
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
                        <h4 class="title-site"> {{ ___('account.edit_account') }}</h4>
                    </div>
                    <form action="{{route('accounts.update', $account->id)}}" method="POST" enctype="multipart/form-data" id="basicform">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <div class="col-12 col-md-6 form-group d-none">
                                <label class=" lebel-style-1" for="type">{{ ___('label.type') }}</label> <span class="text-danger" id="typeRequired"> @error('type') * @enderror</span>
                                <select id="type" name="type" class="form-control input-style-1  select2 " disabled>
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.type') }}</option>
                                    @foreach(\config('rxcourier.account_type') as $key => $value)
                                    <option value="{{ $value }}" {{ $account->type == $value ? 'selected' : '' }}>{{ ___('AccountType.'.$value)}}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class="label-style-1" for="hub">{{ ___('label.hub') }} <span class="text-danger">*</span> </label>
                                <select id="hub" name="hub" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('hub.title') }}</option>
                                    @foreach($hubs as $hub)
                                    <option @selected(old('hub',@$account->hub_id)==$hub->id) value="{{ $hub->id }}">{{ $hub->name }}</option>
                                    @endforeach
                                </select>
                                @error('hub') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" lebel-style-1" for="userID">{{ ___('label.user') }}</label> <span class="text-danger"> *</span>
                                <select id="userID" name="user" class="form-control input-style-1  select2 " data-url="{{route('user.getByHub')}}">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.title') }}</option>
                                    {{-- @foreach($users as $user) --}}
                                    <option @selected(@$user->id == $account->user_id) value="{{ @$user->id }}">{{ @$user->name }}</option>
                                    {{-- @endforeach --}}
                                </select>
                                @error('user')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label class=" lebel-style-1" for="gateway">{{ ___('label.gateway') }}<span class="text-danger">*</span> </label>
                                <select id="gateway" name="gateway" class="form-control input-style-1  select2 ">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.gateway') }}</option>
                                    @foreach(config('site.account_gateways') as $key => $gateway)
                                    <option value="{{ $key }}" @selected(old('gateway', $account->gateway)==$key )>{{ $gateway }}</option>
                                    @endforeach
                                </select>
                                @error('gateway') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-12 col-md-6 form-group" id="balance">
                                <label class=" lebel-style-1" for="balance">{{ ___('label.balance') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="balance" placeholder="{{ ___('placeholder.opening_balance') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->balance}}" require>
                                @error('balance') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="account_holder_name">
                                <label class=" lebel-style-1" for="account_holder_name">{{ ___('label.account_holder_name') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="account_holder_name" placeholder="{{ ___('placeholder.account_holder_name') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->account_holder_name}}" require>
                                @error('account_holder_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="account_no">
                                <label class=" lebel-style-1" for="account_no">{{ ___('label.account_no') }}<span class="text-danger">*</span> </label>
                                <input type="number" name="account_no" placeholder="{{ ___('placeholder.enter_account_no') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->account_no}}" require>
                                @error('account_no') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="bank">
                                <label class=" lebel-style-1" for="bank">{{ ___('label.bank') }}<span class="text-danger">*</span> </label>
                                <select name="bank" class="form-control input-style-1 select2">
                                    <!-- <option value="" @selected(true) @disabled(true)>{{ ___('label.select') }} {{ ___('placeholder.bank_name') }}</option> -->

                                    @foreach($banks as $bank)
                                    <option value="{{ $bank->id}}" @selected(old('bank',$account->bank_id)==$bank->id)> {{ $bank->bank_name }}</option>
                                    @endforeach

                                </select>
                                @error('bank') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="branch_name">
                                <label class=" lebel-style-1" for="branch_name">{{ ___('label.branch_name') }}<span class="text-danger">*</span> </label>
                                <input type="text" name="branch_name" placeholder="{{ ___('placeholder.enter_branch_name') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->branch_name}}" require>
                                @error('branch_name') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group  " id="opening_balance">
                                <label class=" lebel-style-1" for="opening_balance">{{ ___('label.opening_balance') }}<span class="text-danger">*</span> </label>
                                <input type="number" name="opening_balance" placeholder="{{ ___('placeholder.enter_opening_balance') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->opening_balance}}" require>
                                @error('opening_balance') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="mobile">
                                <label class=" lebel-style-1" for="mobile">{{ ___('label.mobile') }}<span class="text-danger">*</span> </label>
                                <input type="number" name="mobile" placeholder="{{ ___('placeholder.mobile') }}" autocomplete="off" class="form-control input-style-1" value="{{$account->mobile}}" require>
                                @error('mobile') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group" id="account_type">
                                <label class=" lebel-style-1" for="account_type">{{ ___('label.account_type') }}<span class="text-danger">*</span> </label>
                                <select name="account_type" class="form-control input-style-1 select2">
                                    <option selected disabled>{{ ___('menus.select') }} {{ ___('label.account_type') }}</option>
                                    @foreach (config('site.account_types.mfs') as $key => $type )
                                    <option value="{{ $key }}" @if(old('account_type', $account->account_type)==$key ) selected @endif>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('account_type') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group   d-block   " id="accountStatus">
                                <label class=" lebel-style-1" for="status">{{ ___('label.status')}}<span class="text-danger">*</span> </label>
                                <select name="status" class="form-control input-style-1  select2">
                                    @foreach(config('site.status.default') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status', $account->status) == $key) ? 'selected' : '' }}>{{ ___('common.'.  $status) }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger mt-2">{{ $message }}</small> @enderror
                            </div>

                        </div>
                        <div class="j-create-btns mt-2">
                            <div class="drp-btns">
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i><span>{{ ___('label.update') }}</span></button>
                                <a href="{{ route('accounts.index') }}" class="j-td-btn btn-red"> <i class="fa-solid fa-rectangle-xmark "></i><span>{{ ___('label.cancel') }}</span> </a>
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
<script src="{{ asset('backend/js/custom/account/account.js') }}"></script>
@endpush
