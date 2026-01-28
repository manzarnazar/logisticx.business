<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Enums\AccountHeads;
use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Models\MerchantPayment;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\BankTransaction;
use App\Repositories\Reports\ReportsInterface;
use App\Http\Resources\Merchant\MerchantParcelResource;
use App\Http\Resources\Merchant\MerchantClosingReportResource;
use App\Http\Resources\Merchant\MerchantParcelStatusReportResource;
use App\Http\Resources\Merchant\MerchantAccountTransactionReportResource;

class MerchantAppReportsController extends Controller
{
    use ApiReturnFormatTrait;

    protected $reportRepo;
    public function __construct(ReportsInterface $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }
    public function parcelSReports(Request $request)
    {
        $parcels        =  $this->reportRepo->merchantParcelReports($request);

        if (!$parcels) {
            return $this->responseWithError(___('alert.no_record_found'));
        }

        $data = MerchantParcelStatusReportResource::collection($parcels);
        return $this->responseWithSuccess(data: $data);
    }

    public function closingReports(Request $request)
    {

        \Log::info($request->all());

        if ($request->has('date')) {
            $date_between = explode('to', $request->date);
            if (is_array($date_between)) {

                $from = $to = Carbon::parse(trim($date_between[0]));

                if (count($date_between) > 1) {
                    $to = Carbon::parse(trim($date_between[1]));
                }

                $request->merge(['date_between' => ['from' => $from->startOfDay(), 'to' => $to->endOfDay()]]);
            }
        }

    

        $report = $this->reportRepo->merchantReport($request);

        \Log::info(json_encode($report));


        $data = new MerchantClosingReportResource($report);


        return $this->responseWithSuccess(data: $data);
    }


    public function accountTransactionListFilter(Request $request)
    {
        $mid = Auth::user()->merchant->id;

        $accounts = MerchantPayment::where('merchant_id', $mid)->get();

        $query = BankTransaction::query();
        $query->with('merchantPayment');
        $query->whereHas('merchantPayment', fn($query) => $query->where('merchant_id', $mid));

        // 🔹 Date filter
        if ($request->date) {
            $date = explode('to', $request->date);
            if (is_array($date)) {
                $from = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                $to   = isset($date[1])
                    ? Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString()
                    : Carbon::parse(trim($date[0]))->endOfDay()->toDateTimeString();

                $query->whereBetween('created_at', [$from, $to]);
            }
        }

        // 🔹 Type filter
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // 🔹 Account filter
        if ($request->account) {
            $query->whereHas('merchantPayment', fn($query) =>
                $query->where('merchant_account', $request->account)
            );
        }

        // 🔹 Use pagination
        $transactions = $query->paginate(settings('paginate_value'));

        if ($transactions->isEmpty()) {
            return $this->responseWithError(___('alert.no_record_found'));
        }

        $data = [
            'transactions' => MerchantAccountTransactionReportResource::collection($transactions),
            'meta' => [
                'current_page' => $transactions->currentPage(),
                'last_page'    => $transactions->lastPage(),
                'per_page'     => $transactions->perPage(),
                'total'        => $transactions->total(),
            ]
        ];

        return $this->responseWithSuccess(
            ___('alert.successful'),
            data: $data
        );
    }

    public function parcelStatusList()
    {
        $statuses = config('site.status.parcel'); // 👈 your config file

        $data = [];
        foreach ($statuses as $key => $status) {
            $data[$key] = ___("parcel." . $status);
        }

        return $this->responseWithSuccess(data: $data);
    }

}
