@extends('backend.payout.index')
@section('title')
{{ ___('label.paypal_payment_details') }}
@endsection
@section('cardcontent')
<div class="row">
    <div class="col-md-12 col-md-offset-3  ">
        <div class="card">
            <div class=" card-body panel panel-default credit-card-box">
                <p class="h3">{{ ___('label.paypal_payout_details') }}</p>
                <div class="panel-body">
                    <div class="col-md-6">
                        <div class="form-group  ">
                            <label class="label-style-1" for="accountId">{{ ___('label.from_account') }}</label>
                            <select id="accountId" name="merchant_id" class="form-control select2">
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
                        <label class="label-style-1">{{ ___('label.amount_usd') }} </label>
                        <div class="form-group d-flex">
                            <input type="number" id="paypal_amount" class="form-control w-unset" />
                        </div>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{ MerchantSearchSettings($merchant_id,'paypal_client_id') }}&currency=USD&intent=capture&enable-funding=venmo" data-sdk-integration-source="integrationbuilder"></script>
<script type="text/javascript">
    var amount = '10';
    var account_id = $('#accountId').val();
    $(document).ready(function() {
        $('#paypal_amount').change(function() {
            amount = $('#paypal_amount').val();
        });
        $('#accountId').change(function() {
            account_id = $(this).val();
        });

    });
    const paypalButtonsComponent = paypal.Buttons({
        style: {
            color: "gold"
            , shape: "rect"
            , layout: "vertical"
        },

        // set up the transaction
        createOrder: (data, actions) => {

            const createOrderPayload = {
                purchase_units: [{
                    amount: {
                        value: amount
                    }
                }]
            };
            return actions.order.create(createOrderPayload);
        },

        // finalize the transaction
        onApprove: (data, actions) => {
            const captureOrderHandler = (details) => {
                const payerName = details.payer.name.given_name;

            };
            $.ajax({
                url: '{{ route("payout.paypal") }}'
                , method: 'post'
                , data: {
                    amount: amount * {
                        {
                            @settings() - > excenseRate - > exchange_rate
                        }
                    }
                    , orderID: data.orderID
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
                    setTimeout(() => {
                        if (response.success == true) {
                            window.location.reload();
                        }
                    }, 3000);
                    console.log(response)
                }
                , error: (error) => {
                    console.log(error);
                    alert('Oops! Something went wrong')
                }
            });
            return actions.order.capture().then(captureOrderHandler);
        },
        // handle unrecoverable errors
        onError: (err) => {
            console.error('An error prevented the buyer from checking out with PayPal');
        }
    });
    paypalButtonsComponent
        .render("#paypal-button-container")
        .catch((err) => {
            console.error('PayPal Buttons failed to render');
        });

</script>
@endpush
