<?php

namespace App\Repositories\Reports;

use App\Enums\CashCollectionStatus;
use App\Enums\ParcelStatus;
use App\Enums\PaymentStatus;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Account;
use App\Models\Backend\DeliveryHeroCommission;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Hub;
use App\Models\Backend\Merchant;
use App\Models\Backend\Parcel;
use App\Models\Backend\ParcelTransaction;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Repositories\Reports\ReportsInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\Attendance\Entities\Attendance;
use Modules\Leave\Entities\LeaveRequest;
use stdClass;

class ReportsRepository implements ReportsInterface
{

    // Methods for merchant Panel 

    public function merchantParcelReports($request)
    {
        $merchantID = Auth::user()->merchant->id;

        $parcels = Parcel::with('parcelEvent')
            ->where('merchant_id', $merchantID)
            ->orderBy('id', 'desc')
            ->where(function ($query) use ($request) {

                if ($request->parcel_date) {


                    if (strpos($request->parcel_date, ' to ') !== false) {
                        // parcel_date with range has 'to '
                        $dateParts = explode(' to ', $request->parcel_date);
                        $from = Carbon::parse(trim($dateParts[0]))->startOfDay()->toDateTimeString();
                        $to   = Carbon::parse(trim($dateParts[1]))->endOfDay()->toDateTimeString();
                        $query->whereBetween('created_at', [$from, $to]);
                    } else {
                        // Single date 
                        $singleDate = Carbon::parse(trim($request->parcel_date))->toDateString();
                        $query->whereDate('created_at', $singleDate);
                    }
                }

                \Log::info($request->all());

                if ($request->parcel_status && is_array($request->parcel_status) && count($request->parcel_status) > 0) {
                    $query->whereIn('status', $request->parcel_status);
                }
            })
            ->orderBy('id', 'desc')
            ->get();

        return $parcels->groupBy('status');
    }

    // Parcel fetching methods by filtering 

    public function fetchParcelStatusReportsByQuery($request)
    {
        $userHubID = $request->hub_id;

        $parcels = Parcel::with('parcelEvent')
            ->when(!blank($userHubID), function ($query) use ($userHubID) {
                $query->where('hub_id', $userHubID);
            })
            ->orderBy('id', 'desc')
            ->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    $date = explode('to', $request->parcel_date);
                    if (is_array($date)) {
                        $from = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to   = Carbon::parse(trim($date[1] ?? $date[0]))->endOfDay()->toDateTimeString();
                        $query->whereBetween('created_at', [$from, $to]);
                    }
                }

                if ($request->parcel_status) {
                    $query->whereIn('status', $request->parcel_status);
                }

                if ($request->merchant) {
                    $query->where(['merchant_id' => $request->merchant]);
                }
            })
            ->orderBy('id', 'desc')
            ->get();

        return $parcels->groupBy('status');
    }

    public function fetchParcelWiseProfitReports($request)
    {
        $userHubID = $request->hub_id;
        if (!blank($userHubID)) {
            return  Parcel::with('parcelEvent', 'parcelTransaction', 'deliveryHeroCommission')->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->where('hub_id', $userHubID)->orderBy('id', 'desc')->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    $date = explode('to', $request->parcel_date);
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1] ?? $date[0]))->endOfDay()->toDateTimeString();
                        $query->whereBetween('updated_at', [$from, $to]);
                    }
                }

                if ($request->parcel_tracking_id) {
                    $query->whereIn('id', $request->parcel_tracking_id);
                }


                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }
            })->orderBy('id', 'desc')->get();
        } else {
            return   Parcel::with('parcelEvent', 'parcelTransaction', 'deliveryHeroCommission')->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->orderBy('id', 'desc')->where(function ($query) use ($request) {
                if ($request->parcel_date) {
                    $date = explode('to', $request->parcel_date);
                    if (is_array($date)) {
                        $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                        $to     = Carbon::parse(trim($date[1] ?? $date[0]))->endOfDay()->toDateTimeString();
                        $query->whereBetween('updated_at', [$from, $to]);
                    }
                }

                if ($request->parcel_tracking_id) {
                    $query->whereIn('id', $request->parcel_tracking_id);
                }

                if ($request->parcel_merchant_id) {
                    $query->where(['merchant_id' => $request->parcel_merchant_id]);
                }
            })->get();
        }
    }

    //salary reports
    public function fetchSalaryReportsByQuery($request)
    {

        $Salaries = SalaryGenerate::with('user.department', 'paidSalary')
            ->when($request->month, function ($query) use ($request) {

                $query->where('month', $request->month);
            })
            ->when($request->user_id, function ($query) use ($request) {
                // If a user name is provided, filter by user name
                $query->whereHas('user', function ($subquery) use ($request) {
                    $subquery->whereIn('id', $request->user_id);
                });
            })
            ->when($request->department, function ($query) use ($request) {
                // If a department ID is provided, filter by department ID
                $query->whereHas('user.department', function ($subquery) use ($request) {
                    $subquery->where('id', $request->department);
                });
            })
            ->get();

        return $Salaries;
    }

    public function fetchLeaveReportsByQuery($request)
    {

        $leaves = LeaveRequest::with('user.department')
            ->when($request->department, function ($query) use ($request) {
                // If a department ID is provided, filter by department ID
                $query->whereHas('user.department', function ($subquery) use ($request) {
                    $subquery->where('id', $request->department);
                });
            })
            ->when($request->user_id, function ($query) use ($request) {
                // If a user name is provided, filter by user name
                $query->whereHas('user', function ($subquery) use ($request) {
                    $subquery->whereIn('id', $request->user_id);
                });
            })
            ->when($request->date, function ($query) use ($request) {
                // If date is provided, filter by date range
                if (strpos($request->date, ' to ') !== false) {
                    // Date with range has 'to '
                    $dateParts = explode(' to ', $request->date);
                    $from = Carbon::parse(trim($dateParts[0]))->startOfDay()->toDateTimeString();
                    $to   = Carbon::parse(trim($dateParts[1] ?? $dateParts[0]))->endOfDay()->toDateTimeString();

                    $query->whereBetween('date', [$from, $to]);
                } else {
                    // Single date 
                    $singleDate = Carbon::parse(trim($request->date))->toDateString();
                    $query->whereDate('date', $singleDate);
                }
            })
            ->orderBy('date', 'asc') // You can change this based on your sorting preference
            ->get();



        return $leaves;
    }

    public function fetchAttendanceReportsByQuery($request)
    {
        $attendances = Attendance::with('user.department')
            ->when($request->department, function ($query) use ($request) {
                // If a department ID is provided, filter by department ID
                $query->whereHas('user.department', function ($subquery) use ($request) {
                    $subquery->where('id', $request->department);
                });
            })
            ->when($request->user_id, function ($query) use ($request) {
                // If a user name is provided, filter by user name
                $query->whereHas('user', function ($subquery) use ($request) {
                    $subquery->whereIn('id', $request->user_id);
                });
            })
            ->when($request->date, function ($query) use ($request) {
                // If date is provided, filter by date range
                if (strpos($request->date, ' to ') !== false) {
                    // Date with range has 'to '
                    $dateParts = explode(' to ', $request->date);
                    $from = Carbon::parse(trim($dateParts[0]))->startOfDay()->toDateTimeString();
                    $to   = Carbon::parse(trim($dateParts[1] ?? $dateParts[0]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('date', [$from, $to]);
                } else {
                    // Single date 
                    $singleDate = Carbon::parse(trim($request->date))->toDateString();
                    $query->whereDate('date', $singleDate);
                }
            })
            ->orderBy('date', 'asc') // You can change this based on your sorting preference
            ->get();

        return $attendances;
    }
    public function fetchVatReportsByQuery($request)
    {

        $vats = ParcelTransaction::with('parcel.merchant')
            ->whereHas('parcel', function ($subquery) {
                $subquery->where(function ($query) {
                    $query->where('status', ParcelStatus::DELIVERED)
                        ->orWhere('status', ParcelStatus::PARTIAL_DELIVERED)
                        ->orWhere('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT);
                });
            })
            ->when($request->merchant, function ($query) use ($request) {
                $query->whereHas('parcel.merchant', function ($subquery) use ($request) {
                    $subquery->where('merchant_id', $request->merchant);
                });
            })
            ->when($request->tracking_id, function ($query) use ($request) {
                $query->whereHas('parcel', function ($subquery) use ($request) {
                    $subquery->where('tracking_id', $request->tracking_id);
                });
            })
            ->when($request->date, function ($query) use ($request) {
                // If date is provided, filter by date range
                if (strpos($request->date, ' to ') !== false) {
                    // Date with range has 'to '
                    $dateParts = explode(' to ', $request->date);
                    $from = Carbon::parse(trim($dateParts[0]))->startOfDay()->toDateTimeString();
                    $to   = Carbon::parse(trim($dateParts[1] ?? $dateParts[0]))->endOfDay()->toDateTimeString();

                    $query->whereBetween('created_at', [$from, $to]);
                } else {
                    // Single date 
                    $singleDate = Carbon::parse(trim($request->date))->toDateString();
                    $query->whereDate('created_at', $singleDate);
                }
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return $vats;
    }

    //merchant reports
    public function merchantReport($request)
    {
        $merchant_id = auth()->user()->user_type == UserType::MERCHANT ? auth()->user()->merchant->id : $request->merchant_id;

        $merchant = Merchant::with(['parcels.parcelTransaction'])->select(['id', 'business_name'])->findOrFail($merchant_id);

        if ($request->has('date_between') && is_array($request->date_between)) {
            $merchant->parcels =  $merchant->parcels->whereBetween('created_at', $request->date_between);
        }

        $parcels = $merchant->parcels;


        $report = new stdClass();

        $report->merchant_id              = $merchant->id;
        $report->business_name            = $merchant->business_name;

        // Calculate the sums for the merchant
        $report->totalDeliveryCharge      = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->charge ?? 0);
        $report->totalCodCharge           = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->cod_charge ?? 0);
        $report->totalLiquidFragileCharge = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->liquid_fragile_charge ?? 0);
        $report->totalVasCharge           = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->vas_charge ?? 0);
        $report->totalDiscount            = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->discount ?? 0);
        $report->totalVat                 = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->vat_amount ?? 0);
        $report->totalCharge              = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $report->totalCashCollection      = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodPending          = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodReceivedByHub    = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodReceivedByAdmin  = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodPaidToMerchant   = $parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        $report->totalPaidByMerchant      = $parcels->where('is_charge_paid', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $report->totalDueToMerchant       = $parcels->where('is_charge_paid', '!=', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $report->totalPayableToMerchant   = $parcels->where('cash_collection_status', '!=', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn($parcel) => $parcel->parcelTransaction->current_payable ?? 0);

        // Calculate parcel counts by status
        $report->totalParcels               = $parcels->count();
        $report->chargePaidParcels          = $parcels->where('is_charge_paid', true)->count();
        $report->chargeNotPaidParcels       = $parcels->where('is_charge_paid', '!=', true)->count();
        $report->codPendingParcels          = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->count();
        $report->codReceivedByHubParcels    = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->count();
        $report->codReceivedByAdminParcels  = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->count();
        $report->codPaidToMerchantParcels   = $parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->count();

        $report->parcelStatusCounts         = $parcels->groupBy('statusName')->map->count()->toArray();

        return $report;
    }

    //hub reports
    public function hubReport($request)
    {
        $hub_id = auth()->user()->user_type == UserType::INCHARGE ? auth()->user()->hub->id : $request->hub_id;

        $hub    = Hub::with(['parcels.parcelTransaction'])->select(['id', 'name'])->findOrFail($hub_id);

        if ($request->has('date_between') && is_array($request->date_between)) {
            $hub->parcels =  $hub->parcels->whereBetween('created_at', $request->date_between);
        }

        // Calculate the sums for the merchant
        $hub->totalDeliveryCharge       = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->charge ?? 0);
        $hub->totalCodCharge            = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->cod_charge ?? 0);
        $hub->totalLiquidFragileCharge  = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->liquid_fragile_charge ?? 0);
        $hub->totalVasCharge            = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->vas_charge ?? 0);
        $hub->totalDiscount             = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->discount ?? 0);
        $hub->totalVat                  = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->vat_amount ?? 0);
        $hub->totalCharge               = $hub->parcels->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $deliveredParcels               = $hub->parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);

        $hub->totalCashCollection       = $deliveredParcels->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $hub->totalCodPending           = $deliveredParcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $hub->totalCodReceivedByHub     = $deliveredParcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $hub->totalCodReceivedByAdmin   = $deliveredParcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $hub->totalCodPaidToMerchant    = $deliveredParcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        $hub->totalPaidByMerchant       = $hub->parcels->where('is_charge_paid', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $hub->totalDueToMerchant        = $hub->parcels->where('is_charge_paid', '!=', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $hub->totalPayableToMerchant    = $hub->parcels->where('cash_collection_status', '!=', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn($parcel) => $parcel->parcelTransaction->current_payable ?? 0);

        // Calculate parcel counts by status
        $hub->totalParcels              = $hub->parcels->count();
        $hub->total_parcels_delivered   = $hub->parcels->where('status', ParcelStatus::DELIVERED)->count();
        $hub->total_parcels_partial_delivered   = $hub->parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();
        $hub->total_parcels_delivery_assigned   = $hub->parcels->whereIn('status', [ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE])->count();

        $hub->chargePaidParcels         = $hub->parcels->where('is_charge_paid', true)->count();
        $hub->chargeNotPaidParcels      = $hub->parcels->where('is_charge_paid', '!=', true)->count();
        $hub->codPendingParcels         = $hub->parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->count();
        $hub->codReceivedByHubParcels   = $hub->parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->count();
        $hub->codReceivedByAdminParcels = $hub->parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->count();
        $hub->codPaidToMerchantParcels  = $hub->parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->count();

        $parcelStatusCounts             = $hub->parcels->groupBy('statusName')->map->count();
        $hub->parcelStatusCounts        = $parcelStatusCounts->toArray();

        $hub->total_delivery_man        = $hub->deliveryMans->count();
        $hub->total_accounts            = $hub->accounts->count();
        $hub->recentPendingParcels      = $hub->parcels->whereIn('status', [ParcelStatus::PENDING])->take(settings('paginate_value'));
        $hub->recentDeliveredParcels    = $hub->parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->take(settings('paginate_value'));

        unset($hub->parcels);

        return $hub;
    }

    // hero report 
    public function heroReport($request)
    {
        $hero_id = auth()->user()->user_type == UserType::DELIVERYMAN ? auth()->user()->deliveryman->id : $request->delivery_man_id;

        $query = DeliveryMan::query();
        $query->with('user:id,name,email,mobile,joining_date,address');
        $query->with('parcelEvents.parcel.parcelTransaction');
        $hero   = $query->findOrFail($hero_id);

        $commissions        = $hero->commissions;

        if ($request->has('date_between') && is_array($request->date_between)) {
            $hero->parcelEvents = $hero->parcelEvents->whereBetween('created_at', $request->date_between);
            $commissions   = $commissions->whereBetween('created_at', $request->date_between);
        }

        $parcels            = $hero->parcelEvents->map(fn($event) => $event->parcel);
        $deliveredParcels   = $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);

        $report = new stdClass();

        $report->hero_id                = $hero->id;
        $report->hub                    = $hero->hub->name ?? null;
        $report->coverage               = $hero->coverage->name ?? null;
        $report->pickup_slot            = $hero->pickupSlot->title ?? null;
        $report->user                   = $hero->user; // Attaching user information to the report

        // cod info
        $report->totalCashCollection    = $deliveredParcels->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->payableToHub           = $deliveredParcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalPaidToHub         = $deliveredParcels->reject(fn($parcel) => $parcel->cash_collection_status === CashCollectionStatus::PENDING->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        // Calculate parcel counts by status
        $report->totalDeliveredParcels        = $deliveredParcels->count();
        $report->totalPartialDeliveredParcels = $deliveredParcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count();
        $report->parcelStatusCounts     = $parcels->groupBy('statusName')->map->count()->toArray();

        // commissions info 
        $report->totalCommission        = $commissions->sum('amount');
        $report->totalCommissionPaid    = $commissions->where('payment_status', PaymentStatus::PAID)->sum('amount');
        $report->totalCommissionDue     = $commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount');

        return $report;
    }

    public function closingReport($request)
    {
        $parcels = Parcel::query();
        $parcels->with(['parcelTransaction']);

        if ($request->has('date_between') && is_array($request->date_between)) {
            $parcels->whereBetween('created_at', $request->date_between);
        }

        $parcels = $parcels->get();

        // Creating a new instance of stdClass to store the calculated report totals and statistics.
        $report = new stdClass();

        // Calculate the sums for the parcel
        $report->totalDeliveryCharge        = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->charge ?? 0);
        $report->totalCodCharge             = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->cod_charge ?? 0);
        $report->totalReturnCharge          = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->return_charge ?? 0);
        $report->totalLiquidFragileCharge   = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->liquid_fragile_charge ?? 0);
        $report->totalVasCharge             = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->vas_charge ?? 0);
        $report->totalDiscount              = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->discount ?? 0);
        $report->totalVat                   = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->vat_amount ?? 0);
        $report->totalCharge                = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $report->totalPaidByMerchant        = $parcels->where('is_charge_paid', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);
        $report->totalDueToMerchant         = $parcels->where('is_charge_paid', '!=', true)->sum(fn($parcel) => $parcel->parcelTransaction->total_charge ?? 0);

        $report->totalCashCollection        = $parcels->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodPending            = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodReceivedByHub      = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodReceivedByAdmin    = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalCodPaidToMerchant     = $parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);
        $report->totalPayableToMerchant     = $parcels->where('cash_collection_status', '!=', CashCollectionStatus::PAID_TO_MERCHANT->value)->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn($parcel) => $parcel->parcelTransaction->current_payable ?? 0);
        $report->heroPayableToHub           = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED])->sum(fn($parcel) => $parcel->parcelTransaction->cash_collection ?? 0);

        // Calculate parcel counts by status
        $report->totalParcels               = $parcels->count();
        $report->chargePaidParcels          = $parcels->where('is_charge_paid', true)->count();
        $report->chargeNotPaidParcels       = $parcels->where('is_charge_paid', '!=', true)->count();
        $report->codPendingParcels          = $parcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->count();
        $report->codReceivedByHubParcels    = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_HUB->value)->count();
        $report->codReceivedByAdminParcels  = $parcels->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN->value)->count();
        $report->codPaidToMerchantParcels   = $parcels->where('cash_collection_status', CashCollectionStatus::PAID_TO_MERCHANT->value)->count();
        $report->codPayableToMerchantParcels = $parcels->where('cash_collection_status', '!=', CashCollectionStatus::PAID_TO_MERCHANT->value)->count();
        $report->parcelStatusCounts         = $parcels->groupBy('statusName')->map->count()->toArray(); // Parcel status counts 

        $report->totalActiveMerchant        = Merchant::where('status', Status::ACTIVE)->count();; // Merchant counts
        $report->totalActiveHub             = Hub::where('status', Status::ACTIVE)->count();; // DeliveryMan counts
        $report->totalActiveHero            = DeliveryMan::where('status', Status::ACTIVE)->count();; // DeliveryMan counts 

        // Account 
        $accounts                           = Account::where('status', Status::ACTIVE)->get();
        $report->totalActiveAccount         = $accounts->count();; // Account counts
        $report->totalAccountBalance        = $accounts->sum('balance');; // Account counts

        // Hero Commission
        $heroCommission                     = DeliveryHeroCommission::query();

        if ($request->has('date_between') && is_array($request->date_between)) {
            $heroCommission->whereBetween('created_at', $request->date_between);
        }

        $heroCommission                     = $heroCommission->get();

        $report->totalHeroCommission        = $heroCommission->sum('amount');
        $report->totalHeroCommissionPaid    = $heroCommission->where('payment_status', PaymentStatus::PAID)->sum('amount');
        $report->totalHeroCommissionDue     = $heroCommission->where('payment_status', PaymentStatus::UNPAID)->sum('amount');

        return $report;
    }
}
