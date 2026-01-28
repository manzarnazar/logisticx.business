@extends('backend.payout.index')
@section('title')
{{ ___('label.stripe_payment_details') }}
@endsection
@section('cardcontent')
<div class="row">
    <div class="col-md-12 col-md-offset-3  ">
        <div class="card">
            <div class=" card-body panel panel-default credit-card-box">
                <p class="h3">{{ ___('label.stripe_payout_details') }}</p>
                <div class="panel-body">
                    <div class="col-md-6">
                        <form id="paymentForm">
                            <div class="form-group  ">
                                <label for="accountId">{{ ___('label.from_account') }}</label>
                                <select id="merchantAccount" name="merchant_id" class="form-control  input-style-1 w-100" data-url="{{ route('parcel.merchant.shops') }}">
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
                                @error('merchant_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <label>{{ ___('label.amount_usd') }} </label>
                            <div class="form-group d-flex">
                                <input type="number" id="stripe_amount" class="form-control w-unset" />
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
@push('scripts')
<script src="https://checkout.stripe.com/checkout.js"> </script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $('#paymentForm').on('submit', function(e) {
        e.preventDefault();

        var amount = $('#stripe_amount').val();
        var account_id = $('#merchantAccount').val();

        if (amount == '') {
            alert('Amount feild is required.');

        } else {
            var handler = StripeCheckout.configure({
                key: '{{ MerchantSearchSettings($merchant_id,"stripe_publishable_key") }}', // your publisher key id
                locale: 'auto'
                , token: function(token) {
                    console.log('Token Created!!');
                    console.log(token)
                    $('#res_token').html(JSON.stringify(token));
                    $.ajax({
                        url: '{{ route("payout.merchant.stripe.post") }}'
                        , method: 'post'
                        , data: {
                            tokenId: token.id
                            , amount: amount * {
                                {
                                    @settings() - > excenseRate - > exchange_rate
                                }
                            }
                            , merchantId: '{{ $merchant_id }}'
                            , accountId: account_id
                        }
                        , success: (response) => {

                            const Toast = Swal.mixin({
                                toast: true
                                , position: 'top-end'
                                , showConfirmButton: false
                                , timer: 3000
                                , timerProgressBar: true
                                , didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success'
                                , title: 'Payment successfully'
                            })
                            if (response.success == true) {
                                window.location.reload();
                            }
                            console.log(response)
                        }
                        , error: (error) => {
                            console.log(error);
                            alert('Oops! Something went wrong')
                        }
                    })
                }
            });
            handler.open({
                name: "{{ settings('name') }}"
                , description: 'Payout'
                , amount: amount * 100
            });
        }
    });

</script>
@endpush
