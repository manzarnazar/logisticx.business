<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Payroll\SalaryController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    Route::get('subscribe',                         [SalaryController::class, 'subscribe'])->name('subscribe.index');

    //salary
    Route::get('salary/index',                      [SalaryController::class, 'index'])->name('salary.index')->middleware('hasPermission:salary_read');
    Route::get('salary/index/create',                     [SalaryController::class, 'create'])->name('salary.create')->middleware('hasPermission:salary_create');
    Route::post('salary/store',                     [SalaryController::class, 'store'])->name('salary.store')->middleware('hasPermission:salary_create');
    Route::post('salary/store/auto-generate',       [SalaryController::class, 'storeAutoGenerate'])->name('salary.storeAutoGenerate')->middleware('hasPermission:salary_generate_bulk');

    Route::get('salary/index/edit/{id}',                  [SalaryController::class, 'edit'])->name('salary.edit')->middleware('hasPermission:salary_update');
    Route::put('salary/update',                     [SalaryController::class, 'update'])->name('salary.update')->middleware('hasPermission:salary_update');
    Route::delete('salary/delete/{id}',             [SalaryController::class, 'delete'])->name('salary.delete')->middleware('hasPermission:salary_delete');

    Route::get('salary/pay/{id}',                   [SalaryController::class, 'payInitialize'])->name('salary.pay.initialize')->middleware('hasPermission:salary_pay');
    Route::post('salary/pay/',                      [SalaryController::class, 'payProcess'])->name('salary.pay.process')->middleware('hasPermission:salary_pay');
    Route::post('salary/pay/reverse',               [SalaryController::class, 'reverseSalaryPay'])->name('salary.pay.reverse')->middleware('hasPermission:salary_pay_reverse');

    Route::get('admin/salary/filter',               [SalaryController::class, 'salaryFilter'])->name('salary.filter')->middleware('hasPermission:salary_read');


    Route::post('salary/users',                     [SalaryController::class, 'Users'])->name('salary.users');

    Route::post('salary/users/get-basic-salary',    [SalaryController::class, 'getBasicSalary'])->name('salary.getBasicSalary');

    Route::get('salary/pay-slip/{id}',              [SalaryController::class, 'payslip'])->name('salary.payslip')->middleware('hasPermission:salary_read');
});
