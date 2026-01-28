<div class="card">

    <div class="card-body">
        <div class="text-center">
            <a href="#" class="user-avatar user-avatar-xl my-3">
                <img src="{{ getImage($merchant->user->upload, 'original','default-image-40x40.png' ) }}" alt="User Avatar" class="rounded-circle user-avatar-xl w-25 object-fit-cover">
            </a>
            <h3 class="card-title mb-2 text-truncate"> <a href="#">{{$merchant->business_name}}</a> </h3>
            <h6 class="card-subtitle text-muted mb-3"> {{ ___('label.email') }}: {{$merchant->user->email}}</h6>
            <h6 class="card-subtitle text-muted mb-3"> {{ ___('label.phone') }}: {{$merchant->user->mobile}}</h6>

        </div>

        <div class="list-group list-group-flush merchant-view">

            <a href="{{ route('merchant.view',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('admin/merchant/view/'.$merchant->id)) ? 'active' : '' }}">{{ ___('merchant.merchant_info') }}</a>

            @if(hasPermission('merchant_delivery_charge_read') == true )
            <a href="{{ route('merchant.deliveryCharge.index',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$merchant->id.'/delivery-charge*')) ? 'active' : '' }}">{{ ___('merchant.delivery_charge') }}</a>
            @endif

            @if(hasPermission('merchant_cod_charge_read') == true )
            <a href="{{ route('merchant.codCharge.index',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$merchant->id.'/cod-charge*')) ? 'active' : '' }}">{{ ___('merchant.cod_charge') }}</a>
            @endif

            @if(hasPermission('merchant_shop_read') == true )
            <a href="{{ route('merchant.shops.index',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$merchant->id.'/shops*','admin/merchant/shops*')) ? 'active' : '' }}">{{ ___('merchant.shop') }}</a>
            @endif
            @if(hasPermission('merchant_payment_account_read') == true )
            <a href="{{ route('merchant.paymentInfo.index',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('merchant/'.$merchant->id.'/payment*')) ? 'active' : '' }}">{{ ___('merchant.payment_account') }}</a>
            @endif
            @if(hasPermission('invoice_read') == true )
            <a href="{{ route('merchant.invoice.index',$merchant->id) }}" class="rounded-lg list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$merchant->id.'/invoice*')) ? 'active' : '' }}">{{ ___('menus.invoice') }}</a>
            @endif

        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-2 mb-md-0 px-1">
                <div class="metric btn bg-primary w-100">
                    <span class="text-white">{{ ___('parcel.parcel')}} </span>
                    <h6 class="text-white"> {{ @$merchant->parcels_count}} </h6>
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0 px-1">
                <div class="metric btn bg-primary w-100">
                    <span class="text-white"> {{ ___('merchant.amount') }} </span>
                    <h6 class="text-white"> {{ @settings('currency') }}{{ @$merchant->parcels->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0) }} </h6>
                </div>
            </div>
            <div class="col-md-4 px-1">
                <div class="metric btn bg-primary w-100">
                    <span class="text-white">{{ ___('parcel.current_payable') }} </span>
                    <h6 class="metric-value text-white">{{ @settings('currency') }}{{ @$merchant->parcels->sum( fn ($parcel) => $parcel->parcelTransaction->current_payable ?? 0) }}</h6>
                </div>
            </div>
        </div>

    </div>
</div>
