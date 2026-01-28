<div class="row">

    <div class="{{ $col ?? 'col-md-4' }}">
        <div class="j-eml-card">
            <h5 class="heading-5"> {{ ___('reports.Delivery_man_info') }}</h5>
            <ol class="list-group list-group-numbered mx-2">

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_cash_collection')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->totalCashCollection,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.Total_paid_to_hub')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->totalPaidToHub,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.Total_Payable_to_hub')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->payableToHub,2) }} </span>
                </li>

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.total_Income')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->totalCommission,2) }} </span>
                </li>


                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCommissionPaid')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->totalCommissionPaid,2) }} </span>
                </li>


                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalCommissionDue')  }}</span>
                    <span> {{settings('currency')}} {{ number_format(@$report->totalCommissionDue,2) }} </span>
                </li>

            </ol>
        </div>
    </div>

    @if(!blank(@$report->parcelStatusCounts))

    <div class="{{ $col ?? 'col-md-4' }}">
        <div class="j-eml-card">
            <h5 class="heading-5">{{ ___('parcel.parcel')}} {{ ___('label.status') }}</h5>
            <ol class="list-group list-group-numbered mx-2">
                @foreach(@$report->parcelStatusCounts as $status=>$parcelCount)
                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ $status }}</span>
                    <span>{{ $parcelCount }}</span>
                </li>
                @endforeach

                <li class="list-group-item d-flex justify-content-between align-items-center p-2 mb-2">
                    <span class="fw-bold">{{ ___('reports.totalDeliveredParcels')  }}</span>
                    <span>{{ @$report->totalDeliveredParcels }}</span>
                </li>
            </ol>
        </div>
    </div>

    @endif
</div>
