<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Report\ReportsController;


Route::middleware(['auth', 'XSS'])->group(function () {

    Route::get('admin/reports/closing',                     [ReportsController::class, 'closingReport'])->name('reports.closing')->middleware('hasPermission:closing_report');

    Route::get('admin/reports/panel',                       [ReportsController::class, 'panelReport'])->name('reports.panel')->middleware('hasPermission:panel_report');

    Route::get('admin/parcel-reports-print-page/{array}',   [ReportsController::class, 'parcelReportsPrint'])->name('parcel.reports.print.page')->middleware('hasPermission:parcel_status_reports');

    Route::post('admin/reports-tracking-parcels',           [ReportsController::class, 'reportsTrackingParcels'])->name('reports-tracking-parcels')->middleware('hasPermission:parcel_wise_profit');

    Route::get('admin/parcel-wise-profit-print-page/{array}', [ReportsController::class, 'parcelWiseProfitPrint'])->name('parcel.wise.profit.print.page')->middleware('hasPermission:parcel_wise_profit');

    Route::get('admin/reports/salary-report-print',         [ReportsController::class, 'SalaryReportPrint'])->name('salary.reports.print.page')->middleware('hasPermission:salary_reports');

    //export
    Route::get('admin/reports/mhd-pdf',                     [ReportsController::class, 'mhdPDF'])->name('merchant.hub.deliveryman.pdf');

    // Show ~ Parcel Status| Parcel-Wise-Profit | Salary | Leave | Attendance | VAT | ---> filtering/initial form 
    Route::get('admin/reports/parcel-status-reports',       [ReportsController::class, 'parcelReports'])->name('parcel.reports')->middleware('hasPermission:parcel_status_reports');

    Route::get('admin/reports/parcel-wise-Profit',          [ReportsController::class, 'parcelWiseReports'])->name('parcel.wise.profit.index')->middleware('hasPermission:parcel_wise_profit');

    Route::get('admin/reports/salary-reports',              [ReportsController::class, 'salaryReports'])->name('salary.reports')->middleware('hasPermission:salary_reports');
    Route::get('admin/reports/leave-reports',               [ReportsController::class, 'leaveReports'])->name('leave.reports')->middleware('hasPermission:leave_reports');
    Route::get('admin/reports/attendance-reports',          [ReportsController::class, 'attendanceReports'])->name('attendance.reports')->middleware('hasPermission:attendance_reports');
    Route::get('admin/reports/vat-reports',                 [ReportsController::class, 'vatReports'])->name('vat.reports')->middleware('hasPermission:vat_reports');

    // Get- Parcel Status | Salary | Leave | Attendance ---> data after filter form process
    Route::get('admin/reports/parcel-status-reports-get',   [ReportsController::class, 'getParcelStatusReports'])->name('parcel.filter.reports')->middleware('hasPermission:parcel_status_reports');

    Route::get('admin/reports/parcel-wise-profit-reports',  [ReportsController::class, 'getParcelWiseProfitReports'])->name('parcel.wise.profit.reports')->middleware('hasPermission:parcel_wise_profit');

    Route::get('admin/reports/salary-reports-get',          [ReportsController::class, 'getSalaryReports'])->name('reports.salary.reports')->middleware('hasPermission:salary_reports');
    Route::get('admin/reports/leave-reports-get',           [ReportsController::class, 'getLeaveReports'])->name('reports.leave.reports')->middleware('hasPermission:leave_reports');
    Route::get('admin/reports/vat-reports-get',             [ReportsController::class, 'getVatReports'])->name('reports.vat.reports')->middleware('hasPermission:vat_reports');
    Route::get('admin/reports/attendance-reports-get',      [ReportsController::class, 'getAttendanceReports'])->name('reports.attendance.reports')->middleware('hasPermission:attendance_reports');


    // Download : Parcel_status |Parcel wise profit | Salary | Leave | Attendance ---> Routes

    // | Admin Panel |

    Route::get('admin/reports/download/parcel-status',      [ReportsController::class, 'downloadAllParcelStatusReportsInPDF'])->name('download.all.parcel_status.reports');
    Route::get('admin/reports/download/parcel-profit',      [ReportsController::class, 'downloadAllParcelProfitReportsInPDF'])->name('download.all.profit.reports');
    Route::get('admin/reports/download/leave',              [ReportsController::class, 'downloadAllLeaveReportsInPDF'])->name('download.all.leave.reports');
    Route::get('admin/reports/download/attendance',         [ReportsController::class, 'downloadAllAttendanceReportsInPDF'])->name('download.all.attendance.reports');
    Route::get('admin/reports/download/salary',             [ReportsController::class, 'downloadAllSalaryReportsInPDF'])->name('download.all.salary.reports');
    Route::get('admin/reports/download/vat',                [ReportsController::class, 'downloadAllVatReportsInPDF'])->name('download.all.vat.reports');

    // | Merchant Panel |
    Route::get('merchant/reports/download/parcel-status',   [ReportsController::class, 'downloadAllMerchantParcelStatusReportsInPDF'])->name('download.all.merchant.parcel_status.reports');
});
