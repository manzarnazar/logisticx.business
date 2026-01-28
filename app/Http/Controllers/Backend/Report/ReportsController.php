<?php

namespace App\Http\Controllers\Backend\Report;

use App\Enums\Status;
use Illuminate\Http\Request;

use App\Models\User;
use App\Enums\UserType;
use Barryvdh\DomPDF\PDF;
use App\Models\Backend\Parcel;
use App\Exports\MerchantReports;
use App\Http\Controllers\Controller;
use App\Repositories\Hub\HubInterface;
use Modules\Leave\Entities\LeaveRequest;
use App\Models\Backend\ParcelTransaction;
use Modules\Attendance\Entities\Attendance;
use App\Http\Requests\Reports\FilterRequest;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Repositories\Reports\ReportsInterface;
use App\Repositories\Merchant\MerchantInterface;
use App\Http\Requests\Reports\PanelReportsRequest;
use App\Repositories\Department\DepartmentInterface;
use App\Repositories\DeliveryMan\DeliveryManInterface;
use App\Http\Requests\Reports\FilterSalaryReportRequest;
use App\Repositories\BankTransaction\BankTransactionInterface;
use Carbon\Carbon;
use Modules\Attendance\Repositories\Attendance\AttendanceInterface;

class ReportsController extends Controller
{
    protected $repo;
    protected $hub;
    protected $merchant;
    protected $deliveryman;
    protected $bankTransaction;
    protected $departmentRepo;
    protected $attendanceRepo;
    protected $merchantRepo;

    public function __construct(
        ReportsInterface $repo,
        HubInterface $hub,
        MerchantInterface $merchant,
        BankTransactionInterface $bankTransaction,
        DeliveryManInterface $deliveryman,
        DepartmentInterface $departmentRepo,
        AttendanceInterface $attendanceRepo,
        MerchantInterface $merchantRepo
    ) {
        $this->repo                 =  $repo;
        $this->hub                  =  $hub;
        $this->merchant             =  $merchant;
        $this->deliveryman          =  $deliveryman;
        $this->bankTransaction      =  $bankTransaction;
        $this->departmentRepo       =  $departmentRepo;
        $this->attendanceRepo       =  $attendanceRepo;
        $this->merchantRepo         =  $merchantRepo;
    }

    public function parcelReportsPrint(Request $request, $array)
    {
        $parcel_ids  = [];
        foreach (explode(',', $array) as  $id) {
            if ($id !== "") :
                $parcel_ids[] = $id;
            endif;
        }
        $parcels    = Parcel::whereIn('id', $parcel_ids)->orderBy('id')->get();
        $parcels    = $parcels->groupBy('status');

        return view('backend.reports.parcel_reports_print', compact('parcels'));
    }

    public function reportsTrackingParcels(Request $request)
    {
        if (request()->ajax()) :


            $parcels                 = [];
            $parcls                  = Parcel::where('tracking_id', 'like', '%' . $request->search . '%')->paginate(settings('paginate_value'));
            foreach ($parcls as $key => $parcel) {
                $parcels[]           = [
                    'id'             => $parcel->id,
                    'text'           => $parcel->tracking_id
                ];
            }
            return response()->json($parcels);
        endif;
        return '';
    }

    public function parcelWiseProfitPrint($array)
    {

        $parcel_ids           = [];
        foreach (explode(',', $array) as  $id) {
            if ($id !== "") :
                $parcel_ids[] = $id;
            endif;
        }
        $parcels              = Parcel::whereIn('id', $parcel_ids)->orderBy('id')->get();

        return view('backend.reports.parcel_wise_profit_print', compact('parcels'));
    }

    // View only
    public function parcelReports(Request $request)
    {

        $parcels       = $this->repo->fetchParcelStatusReportsByQuery($request);
        $hubs          = $this->hub->hubs();
        $merchants     = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));

        $filteredIds = [];

        foreach ($parcels as $key => $parcel) {
            foreach ($parcel as $key => $parcl) {
                $filteredIds = $parcl->pluck('id')->toArray();
            }
        }

        return view('backend.reports.parcel_reports', compact('parcels', 'request', 'hubs', 'filteredIds', 'merchants'));

        // $hubs           = $this->hub->hubs();
        // $merchants      = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));
        // return view('backend.reports.parcel_reports', compact('request', 'hubs', 'merchants'));
    }

    public function parcelWiseReports(Request $request)
    {
        $hubs         = $this->hub->hubs();
        $merchants    = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));
        return view('backend.reports.parcel_wise_profit', compact('request', 'hubs', 'merchants'));
    }

    public function leaveReports(Request $request)
    {
        $departments = $this->departmentRepo->activeDepartments();
        return view('backend.reports.leave_reports', compact('request', 'departments'));
    }

    public function attendanceReports(Request $request)
    {
        $users       = User::whereNot('user_type', UserType::MERCHANT)->paginate(settings('paginate_value'));
        $departments = $this->departmentRepo->activeDepartments();
        return view('backend.reports.attendance_reports', compact('request', 'departments', 'users'));
    }

    public function salaryReports(Request $request)
    {
        $departments = $this->departmentRepo->activeDepartments();
        return view('backend.reports.salary_reports', compact('request', 'departments'));
    }

    public function vatReports(Request $request)
    {
        $merchants = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));
        return view('backend.reports.vat_reports', compact('request', 'merchants'));
    }

    // After filtering form handle
    public function getParcelStatusReports(Request $request)
    {
        $parcels       = $this->repo->fetchParcelStatusReportsByQuery($request);
        $hubs          = $this->hub->hubs();
        $merchants     = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));

        $filteredIds = [];

        foreach ($parcels as $key => $parcel) {
            foreach ($parcel as $key => $parcl) {
                $filteredIds = $parcl->pluck('id')->toArray();
            }
        }

        return view('backend.reports.parcel_reports', compact('parcels', 'request', 'hubs', 'filteredIds', 'merchants'));
    }

    public function getParcelWiseProfitReports(Request $request)
    {
        $parcels      = $this->repo->fetchParcelWiseProfitReports($request);
        $merchants    = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));
        $hubs         = $this->hub->hubs();
        $print        = true;
        $filteredIds = $parcels->pluck('id')->toArray();

        return view('backend.reports.parcel_wise_profit', compact('parcels', 'request', 'hubs', 'print', 'filteredIds', 'merchants'));
    }

    public function getSalaryReports(FilterSalaryReportRequest $request)
    {
        $departments = $this->departmentRepo->activeDepartments();
        $salaries    = $this->repo->fetchSalaryReportsByQuery($request);
        $filteredIds = $salaries->pluck('id')->toArray();

        return view('backend.reports.salary_reports', compact('request', 'salaries', 'filteredIds', 'departments'));
    }

    public function getLeaveReports(FilterRequest $request)
    {
        $departments = $this->departmentRepo->activeDepartments();
        $leaves      = $this->repo->fetchLeaveReportsByQuery($request);

        $filteredIds = $leaves->pluck('id')->toArray();
        return view('backend.reports.leave_reports', compact('request', 'leaves', 'departments', 'filteredIds'));
    }

    public function getAttendanceReports(FilterRequest $request)
    {
        $departments = $this->departmentRepo->activeDepartments();
        $attendances = $this->repo->fetchAttendanceReportsByQuery($request);

        // Separating the fetched data's ids in an array
        $filteredIds = $attendances->pluck('id')->toArray();

        return view('backend.reports.attendance_reports', compact('request', 'attendances', 'departments', 'filteredIds'));
    }

    public function getVatReports(Request $request)
    {
        $vats        = $this->repo->fetchVatReportsByQuery($request);
        $merchants   = $this->merchantRepo->all(status: Status::ACTIVE, paginate: settings('paginate_value'));
        $filteredIds = $vats->pluck('id')->toArray();

        return view('backend.reports.vat_reports', compact('request', 'vats', 'merchants', 'filteredIds'));
    }

    public function downloadAllParcelStatusReportsInPDF(Request $request)
    {
        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {

            $statusWithCounts = Parcel::with('parcelEvent')
                ->whereIn('id', $filteredIds)
                ->pluck('status')
                ->countBy()
                ->toArray();

            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_parcel_status_reports_download_format', ['statusWithCounts' => $statusWithCounts]);

            return $pdf->download('parcel_status_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }
    public function downloadAllParcelProfitReportsInPDF(Request $request)
    {
        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {

            $parcels = Parcel::with('parcelTransaction', 'deliveryHeroCommission')
                ->whereIn('id', $filteredIds)
                ->get();

            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_parcel_profit_reports_download_format', ['parcels' => $parcels]);

            return $pdf->download('parcel_profit_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }

    public function downloadAllLeaveReportsInPDF(Request $request)
    {
        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {
            $leaves = LeaveRequest::with('user.department')
                ->whereIn('id', $filteredIds)
                ->get();

            // Check if any leaves are found
            if ($leaves->isEmpty()) {
                // Handle the case where no leaves match the provided IDs
                return redirect()->back()->with('error', 'No leaves found for the provided IDs.');
            }
            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_leave_reports_download_format', ['leaves' => $leaves]);

            return $pdf->download('leave_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }

    public function downloadAllAttendanceReportsInPDF(Request $request)
    {

        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));


        if (!empty($filteredIds)) {
            $attendances = Attendance::with('user.department')
                ->whereIn('id', $filteredIds)
                ->get();


            // Check if any attendances are found
            if ($attendances->isEmpty()) {
                // Handle the case where no attendances match the provided IDs
                return redirect()->back()->with('error', 'No attendances found for the provided IDs.');
            }

            // Generate PDF

            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_attendance_reports_download_format', ['attendances' => $attendances]);

            return $pdf->download('All_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }

    public function downloadAllVatReportsInPDF(Request $request)
    {

        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {
            $vats = ParcelTransaction::with('parcel.merchant')
                ->whereIn('id', $filteredIds)
                ->get();

            // Check if any vats are found
            if ($vats->isEmpty()) {
                // Handle the case where no salaries match the provided IDs
                return redirect()->back()->with('error', 'No salaries found for the provided IDs.');
            }

            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_vat_reports_download_format', ['vats' => $vats]);

            return $pdf->download('All_VAT_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }
    public function downloadAllSalaryReportsInPDF(Request $request)
    {

        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {
            $salaries = SalaryGenerate::with('user', 'paidSalary')
                ->whereIn('id', $filteredIds)
                ->get();

            // Check if any salaries are found
            if ($salaries->isEmpty()) {
                // Handle the case where no salaries match the provided IDs
                return redirect()->back()->with('error', 'No salaries found for the provided IDs.');
            }

            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_salary_reports_download_format', ['salaries' => $salaries]);

            return $pdf->download('All_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }


    // Merchant panel parcel downloads

    public function downloadAllMerchantParcelStatusReportsInPDF(Request $request)
    {

        // getting from blade : Those id's which are in list after filter
        $filteredIds = explode(',', $request->input('filtered_ids', ''));

        if (!empty($filteredIds)) {

            $statusWithCounts = Parcel::with('parcelEvent')
                ->whereIn('id', $filteredIds)
                ->pluck('status')
                ->countBy()
                ->toArray();

            // Generate PDF
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('backend.reports.download_formats.all_parcel_status_reports_download_format', ['statusWithCounts' => $statusWithCounts]);

            return $pdf->download('parcel_status_Reports.pdf');
        }

        return redirect()->back()->with('error', 'No filtered IDs provided for download.');
    }





    public function SalaryReportPrint(Request $request)
    {
        $totalSalary       = $this->repo->fetchSalaryReportsByQuery($request);
        $salaries          = $totalSalary['salary'];
        $salaryPayments    = $totalSalary['salaryPayment'];

        return view('backend.reports.salary_reports_print', compact('request', 'salaries', 'salaryPayments'));
    }

    public function panelReport(PanelReportsRequest $request)
    {
        $report  = null;

        if ($request->user_type == UserType::MERCHANT) {
            $report = $this->repo->merchantReport($request);
        }

        if ($request->user_type == UserType::HUB) {
            $report = $this->repo->hubReport($request);
        }

        if ($request->user_type == UserType::DELIVERYMAN) {
            $report = $this->repo->heroReport($request);
        }
        // return $report;
        if ($request->print && $report) {
            return view('backend.reports.panel.print', compact('report'));
        }

        return view('backend.reports.panel.index', compact('report'));
    }

    public function closingReport(Request $request)
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

        $report = $this->repo->closingReport($request);

        if ($request->print) {
            return view('backend.reports.closing.print', compact('report'));
        }

        return view('backend.reports.closing.index', compact('report'));
    }
}
