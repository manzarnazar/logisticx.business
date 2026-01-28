<?php

namespace App\Http\Controllers\Backend\MerchantPanel;

use App\Enums\ParcelStatus;
use App\Enums\StatementType;
use App\Http\Controllers\Controller;
use App\Repositories\Reports\ReportsInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    private $reportRepo;

    public function __construct(ReportsInterface $reportRepo)
    {
        $this->reportRepo = $reportRepo;
    }

    public function closingReports(Request $request)
    {
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

        if ($request->print) {
            return view('backend.merchant_panel.reports.closing_report_print', compact('report'));
        }

        return view('backend.merchant_panel.reports.closing_report', compact('report'));
    }
}
