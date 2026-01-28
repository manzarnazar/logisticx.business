<div class="row">

    {{-- parcels_statistics --}}
    <div class="col-md-4">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.parcels_statistics') }}</h5>
            <ol class="list-group list-group-numbered mx-2">

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalParcels')  }}</span>
                    <span>{{ @$report->totalParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.chargePaidParcels')  }}</span>
                    <span>{{ @$report->chargePaidParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.chargeNotPaidParcels')  }}</span>
                    <span>{{ @$report->chargeNotPaidParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.codPendingParcels')  }}</span>
                    <span>{{ @$report->codPendingParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.codReceivedByHubParcels')  }}</span>
                    <span>{{ @$report->codReceivedByHubParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.codReceivedByAdminParcels')  }}</span>
                    <span>{{ @$report->codReceivedByAdminParcels }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.codPaidToMerchantParcels')  }}</span>
                    <span>{{ @$report->codPaidToMerchantParcels }}</span>
                </li>

            </ol>
        </div>
    </div>

    {{-- parcels as status --}}

    @if(!blank(@$report->parcelStatusCounts))
    <div class="col-md-4">
        <div class="j-eml-card">
            <h5 class="heading-5">{{ ___('parcel.parcel')}} {{ ___('label.status') }}</h5>
            <ol class="list-group list-group-numbered mx-2">

                @foreach(@$report->parcelStatusCounts as $status => $parcelCount)
                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ $status }}</span>
                    <span>{{ $parcelCount }}</span>
                </li>
                @endforeach

            </ol>
        </div>
    </div>
    @endif

    {{-- profit_info --}}
    <div class="col-md-4  ">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.profit_info') }}</h5>
            <ol class="list-group list-group-numbered mx-2">

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.Total_Delivery_Charge')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalDeliveryCharge,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.COD_Charge')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCodCharge,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_liquid_fragile_amount')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalLiquidFragileCharge,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_vas')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalVasCharge,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_discount')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalDiscount,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_charge_with_vat')   }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCharge,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_vat')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalVat,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_charge_without_vat')   }}</span>
                    <span> {{settings('currency')}} {{ number_format(($report->totalCharge- $report->totalVat),2) }} </span>
                </li>

            </ol>
        </div>
    </div>

    {{-- merchant info --}}
    <div class="col-md-4">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.merchant_info') }}</h5>
            <ol class="list-group list-group-numbered mx-2">


                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalActiveMerchant')  }}</span>
                    <span> {{ $report->totalActiveMerchant }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_cod')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCashCollection,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCodPending')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCodPending,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCodReceivedByHub')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCodReceivedByHub,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCodReceivedByAdmin')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCodReceivedByAdmin,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCodPaidToMerchant')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalCodPaidToMerchant,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalPaidByMerchant')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalPaidByMerchant,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalDueToMerchant')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalDueToMerchant,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalPayableToMerchant')  }}</span>
                    <span> {{settings('currency')}} {{ number_format($report->totalPayableToMerchant,2) }} </span>
                </li>

            </ol>
        </div>
    </div>

    {{-- Hero Info --}}
    <div class="col-md-4">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.hero_info') }} </h5>
            <ol class="list-group list-group-numbered mx-2">

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalActiveHero')  }}</span>
                    <span> {{ $report->totalActiveHero }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalHeroCommission')  }}</span>
                    <span> {{ $report->totalHeroCommission }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalHeroCommissionPaid')  }}</span>
                    <span> {{ $report->totalHeroCommissionPaid }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalHeroCommissionDue')  }}</span>
                    <span> {{ $report->totalHeroCommissionDue }} </span>
                </li>

            </ol>
        </div>
    </div>

    {{-- Others Info --}}
    <div class="col-md-4">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.others_info') }} </h5>
            <ol class="list-group list-group-numbered mx-2">

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalActiveHub')  }}</span>
                    <span> {{ $report->totalActiveHub }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalActiveAccount')  }}</span>
                    <span> {{ $report->totalActiveAccount }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalAccountBalance')  }}</span>
                    <span> {{ $report->totalAccountBalance }} </span>
                </li>

            </ol>
        </div>
    </div>

</div>
