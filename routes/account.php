<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Account\BankController;
use App\Http\Controllers\Backend\Account\IncomeController;
use App\Http\Controllers\Backend\Account\AccountController;
use App\Http\Controllers\Backend\Account\ExpenseController;
use App\Http\Controllers\Backend\Account\AccountHeadsController;
use App\Http\Controllers\Backend\Account\FundTransferController;
use App\Http\Controllers\Backend\Account\BankTransactionController;

Route::group(['middleware' => ['auth', 'XSS']], function () {

    // Accounts Routes
    Route::get('admin/accounts/index',                      [AccountController::class, 'index'])->name('accounts.index')->middleware('hasPermission:account_read');
    Route::get('admin/accounts/filter',                     [AccountController::class, 'filter'])->name('accounts.filter')->middleware('hasPermission:account_read');
    Route::get('admin/accounts/index/create',                     [AccountController::class, 'create'])->name('accounts.create')->middleware('hasPermission:account_create');
    Route::post('admin/accounts/store',                     [AccountController::class, 'store'])->name('accounts.store')->middleware('hasPermission:account_create');
    Route::get('admin/accounts/index/edit/{id}',                  [AccountController::class, 'edit'])->name('accounts.edit')->middleware('hasPermission:account_update');
    Route::get('admin/accounts/view/{id}',                  [AccountController::class, 'view'])->name('accounts.view');
    Route::put('admin/accounts/update/{id}',                [AccountController::class, 'update'])->name('accounts.update')->middleware('hasPermission:account_update');
    Route::delete('admin/accounts/delete/{id}',             [AccountController::class, 'destroy'])->name('accounts.delete')->middleware('hasPermission:account_delete');
    Route::post('admin/accounts/current-balance',           [AccountController::class, 'currentBalance'])->name('accounts.current-balance');
    Route::post('admin/accounts/search-by-hub',             [AccountController::class, 'searchByHub'])->name('accounts.searchByHub');
    Route::post('admin/accounts/search-by-user',            [AccountController::class, 'searchByUser'])->name('accounts.searchByUser');
    Route::post('admin/accounts/search',                    [AccountController::class, 'searchAccount'])->name('accounts.search');

    // Bank Routes
    Route::get('admin/banks/index',                         [BankController::class, 'index'])->name('banks.index')->middleware('hasPermission:bank_read');
    Route::get('admin/banks/filter',                        [BankController::class, 'filter'])->name('banks.filter')->middleware('hasPermission:bank_read');
    Route::get('admin/banks/index/create',                        [BankController::class, 'create'])->name('banks.create')->middleware('hasPermission:bank_create');
    Route::post('admin/banks/store',                        [BankController::class, 'store'])->name('banks.store')->middleware('hasPermission:bank_create');
    Route::get('admin/banks/index/edit/{id}',                     [BankController::class, 'edit'])->name('banks.edit')->middleware('hasPermission:bank_update');
    Route::get('admin/banks/view/{id}',                     [BankController::class, 'view'])->name('banks.view');
    Route::put('admin/banks/update/{id}',                   [BankController::class, 'update'])->name('banks.update')->middleware('hasPermission:bank_update');
    Route::delete('admin/banks/delete/{id}',                [BankController::class, 'destroy'])->name('banks.delete')->middleware('hasPermission:bank_delete');


    //account heads
    Route::get('admin/account-heads',                       [AccountHeadsController::class, 'index'])->name('account.heads.index')->middleware('hasPermission:account_heads_read');
    Route::get('admin/account-heads/create',                [AccountHeadsController::class, 'create'])->name('account.heads.create')->middleware('hasPermission:account_heads_create');
    Route::post('admin/account-heads/store',                [AccountHeadsController::class, 'store'])->name('account.heads.store')->middleware('hasPermission:account_heads_create');
    Route::get('admin/account-heads/edit/{id}',             [AccountHeadsController::class, 'edit'])->name('account.heads.edit')->middleware('hasPermission:account_heads_update');
    Route::get('admin/account-heads/view/{id}',             [AccountHeadsController::class, 'view'])->name('account.heads.view');
    Route::put('admin/account-heads/update/{id}',           [AccountHeadsController::class, 'update'])->name('account.heads.update')->middleware('hasPermission:account_heads_update');
    Route::delete('admin/account-heads/delete/{id}',        [AccountHeadsController::class, 'destroy'])->name('account.heads.delete')->middleware('hasPermission:account_heads_delete');

    // Fund Transfer Routes
    Route::get('admin/fund-transfer/index',                 [FundTransferController::class, 'index'])->name('fund-transfer.index')->middleware('hasPermission:fund_transfer_read');
    Route::get('admin/fund-transfer/index/create',                [FundTransferController::class, 'create'])->name('fund-transfer.create')->middleware('hasPermission:fund_transfer_create');
    Route::post('admin/fund-transfer/store',                [FundTransferController::class, 'store'])->name('fund-transfer.store')->middleware('hasPermission:fund_transfer_create');
    Route::get('admin/fund-transfer/index/edit/{id}',             [FundTransferController::class, 'edit'])->name('fund-transfer.edit')->middleware('hasPermission:fund_transfer_update');
    Route::get('admin/fund-transfer/view/{id}',             [FundTransferController::class, 'view'])->name('fund-transfer.view');
    Route::put('admin/fund-transfer/update/{id}',           [FundTransferController::class, 'update'])->name('fund-transfer.update')->middleware('hasPermission:fund_transfer_update');
    Route::delete('admin/fund-transfer/delete/{id}',        [FundTransferController::class, 'destroy'])->name('fund-transfer.delete')->middleware('hasPermission:fund_transfer_delete');
    Route::get('admin/fund-transfer/specific/search',       [FundTransferController::class, 'fundTransferSpecificSearch'])->name('fund.transfer.specific.search')->middleware('hasPermission:fund_transfer_read');
    Route::get('admin/fund-transfer/search/flter/print',    [FundTransferController::class, 'fundTransferSearchFilterPrint'])->name('fund.transfer.search.filter.print')->middleware('hasPermission:fund_transfer_read');
    Route::get('admin/fund-transfer/filter',                [FundTransferController::class, 'fundTransferFilter'])->name('fund.transfer.filter')->middleware('hasPermission:fund_transfer_read');

    // Account income
    Route::get('admin/income',                              [IncomeController::class, 'index'])->name('income.index')->middleware('hasPermission:income_read');
    Route::get('admin/income/view/{id}',                    [IncomeController::class, 'view'])->name('income.view')->middleware('hasPermission:income_read');
    Route::get('admin/income/create',                       [IncomeController::class, 'create'])->name('income.create')->middleware('hasPermission:income_create');
    Route::post('admin/income/store',                       [IncomeController::class, 'store'])->name('income.store')->middleware('hasPermission:income_create');
    Route::get('admin/income/edit/{id}',                    [IncomeController::class, 'edit'])->name('income.edit')->middleware('hasPermission:income_update');
    Route::put('admin/income/update',                       [IncomeController::class, 'update'])->name('income.update')->middleware('hasPermission:income_update');
    Route::delete('admin/income/delete/{id}',               [IncomeController::class, 'destroy'])->name('income.delete')->middleware('hasPermission:income_delete');

    Route::get('admin/income/filter',                       [IncomeController::class, 'filter'])->name('income.filter')->middleware('hasPermission:income_read');

    Route::post('admin/income/search-account/{id}',         [IncomeController::class, 'searchAccount'])->name('income.search-account');
    Route::post('admin/income/balance-check',               [IncomeController::class, 'balanceCheck'])->name('income.balance.check');
    Route::post('admin/income/hub-user-accounts',           [IncomeController::class, 'hubUserAccounts'])->name('income.hub-user-accounts');
    Route::post('admin/income/users',                       [IncomeController::class, 'IncomeUsers'])->name('income.users');

    // Account expense
    Route::get('admin/expense',                             [ExpenseController::class, 'index'])->name('expense.index')->middleware('hasPermission:expense_read');
    Route::get('admin/expense/view/{id}',                   [ExpenseController::class, 'view'])->name('expense.view')->middleware('hasPermission:expense_read');
    Route::get('admin/expense/filter',                      [ExpenseController::class, 'filter'])->name('expense.filter')->middleware('hasPermission:expense_read');
    Route::get('admin/expense/create',                      [ExpenseController::class, 'create'])->name('expense.create')->middleware('hasPermission:expense_create');
    Route::post('admin/expense/search-account/{id}',        [ExpenseController::class, 'searchAccount'])->name('expense.search-account');
    Route::post('admin/expense/store',                      [ExpenseController::class, 'store'])->name('expense.store')->middleware('hasPermission:expense_create');
    Route::get('admin/expense/edit/{id}',                   [ExpenseController::class, 'edit'])->name('expense.edit')->middleware('hasPermission:expense_update');
    Route::put('admin/expense/update',                      [ExpenseController::class, 'update'])->name('expense.update')->middleware('hasPermission:expense_update');
    Route::delete('admin/expense/delete/{id}',              [ExpenseController::class, 'destroy'])->name('expense.delete')->middleware('hasPermission:expense_delete');

    Route::post('admin/expense/users',                      [ExpenseController::class, 'ExpenseUsers'])->name('expense.users');

    // Bank transaction
    Route::get('admin/bank-transaction',                    [BankTransactionController::class, 'index'])->name('bank-transaction.index')->middleware('hasPermission:bank_transaction_read');
    Route::Post('admin/bank-transaction/filter',            [BankTransactionController::class, 'filter'])->name('bank-transaction.filter')->middleware('hasPermission:bank_transaction_read');

    Route::get('admin/bank-transaction/filter/print',       [BankTransactionController::class, 'bankTransactionPrint'])->name('bank.transaction.filter.print');
});
