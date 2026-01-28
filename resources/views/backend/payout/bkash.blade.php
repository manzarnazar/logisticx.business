@extends('backend.payout.index')
@section('title')
{{ ___('label.bkash_payment_details') }}
@endsection
@section('cardcontent')
<div class="row">
    <div class="col-md-12 col-md-offset-3  ">
        <div class="card">
            <div class=" card-body panel panel-default credit-card-box">
                <p class="h3">{{ ___('label.bkash_payout_details') }}</p>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form action="{{route('payout.bkash.redirect')}}" method="get">
                            <input type="hidden" name="merchant_id" value="{{ $merchant_id }}" />
                            <div class="form-group  ">
                                <label class="label-style-1" for="accountId">{{ ___('label.from_account') }}</label>
                                <select id="accountId" name="account_id" class="form-control select2">
                                    @foreach ($accounts as $account)
                                    @if ($account->gateway == 1)
                                    <option value="{{ $account->id }}">{{ $account->user->name }} | {{ ___('merchant.cash') }} : {{ $account->balance }}</option>
                                    @elseif($account->gateway == 3 || $account->gateway == 4 || $account->gateway == 5)
                                    <option value="{{ $account->id }}">{{$account->account_holder_name}} |No : {{ $account->mobile }}| @if($account->type == 1) {{ ___('merchant.merchant') }} @else {{ ___('placeholder.persional') }} @endif | {{ ___('merchant.current_balance') }}: {{ $account->balance }} </option>
                                    @else
                                    <option value="{{ $account->id }}">{{$account->account_holder_name}} | A.No : {{ $account->account_no }} | {{ ___('merchant.current_balance') }}: {{ $account->balance }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <label class="label-style-1">{{ ___('label.amount') }} </label>
                            <div class="form-group d-flex">
                                <input type="number" name="amount" id="bkash_amount" class="form-control input-style-1 w-unset" value="{{ old('amount') }}" />
                                <button type="submit" class="j-td-btn"><i class="fa-solid fa-floppy-disk "></i> {{ ___('label.pay_now') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
