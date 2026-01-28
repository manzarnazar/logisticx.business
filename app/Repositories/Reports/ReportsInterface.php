<?php

namespace App\Repositories\Reports;

interface  ReportsInterface
{
    public function fetchParcelStatusReportsByQuery($request);
    public function merchantParcelReports($request);
    public function fetchParcelWiseProfitReports($request);
    public function fetchSalaryReportsByQuery($request);
    public function fetchLeaveReportsByQuery($request);
    public function fetchAttendanceReportsByQuery($request);
    public function fetchVatReportsByQuery($request);
    // public function salaryReportsPrint($request);

    public function merchantReport($request);

    public function hubReport($request);

    public function heroReport($request);

    public function closingReport($request);
}
