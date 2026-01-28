<?php

namespace App\Http\Controllers\Backend\DeliverymanPanel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Reports\ReportsInterface;
use Carbon\Carbon;

class ReportController extends Controller
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

        $report = $this->reportRepo->heroReport($request);

        if ($request->print) {
            return view('backend.deliveryman_panel.reports.closing_report_print', compact('report'));
        }

        return view('backend.deliveryman_panel.reports.closing_report', compact('report'));
    }
}
