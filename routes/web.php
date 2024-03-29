<?php

use App\Expense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::get('/test', function () {
    $income = 2000;
    $expenses = Expense::get();
    dd($expenses);
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::redirect('/', '/admin/expenses');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Expensecategories
    Route::delete('expense-categories/destroy', 'ExpenseCategoryController@massDestroy')->name('expense-categories.massDestroy');
    Route::resource('expense-categories', 'ExpenseCategoryController');

    // TodoCategories
    Route::delete('todo-categories/destroy', 'TodoCategoryController@massDestroy')->name('todo-categories.massDestroy');
    Route::resource('todo-categories', 'TodoCategoryController');

    // Todo
    Route::delete('todo/destroy', 'TodoController@massDestroy')->name('todo.massDestroy');
    Route::resource('todo', 'TodoController');

    // Incomecategories
    Route::delete('income-categories/destroy', 'IncomeCategoryController@massDestroy')->name('income-categories.massDestroy');
    Route::resource('income-categories', 'IncomeCategoryController');

    // Expenses
    Route::delete('expenses/destroy', 'ExpenseController@massDestroy')->name('expenses.massDestroy');
    Route::resource('expenses', 'ExpenseController');
    Route::get('expense/import', 'ExpenseController@importView')->name('expenses.import');
    Route::post('expense/import', 'ExpenseController@import')->name('expenses.import.store');


    // Sales
    Route::delete('sales/destroy', 'SalesController@massDestroy')->name('sales.massDestroy');
    Route::resource('sales', 'SalesController');
    Route::get('sale/import', 'SalesController@importView')->name('sales.import');
    Route::post('sale/import', 'SalesController@import')->name('sales.import.store');

    // Purchase
    Route::delete('purchases/destroy', 'PurchaseController@massDestroy')->name('purchases.massDestroy');
    Route::resource('purchases', 'PurchaseController');
    Route::get('purchase/import', 'PurchaseController@importView')->name('purchases.import');
    Route::post('purchase/import', 'PurchaseController@import')->name('purchase.import.store');

    // Incomes
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');
    Route::get('income/import', 'IncomeController@importView')->name('income.import');
    Route::post('income/import', 'IncomeController@import')->name('income.import.store');
    // Payroll
    Route::delete('payrolls/destroy', 'PayrollController@massDestroy')->name('payrolls.massDestroy');
    Route::resource('payrolls', 'PayrollController');
    Route::get('payroll/import', 'PayrollController@importView')->name('payrolls.import');
    Route::post('payroll/import', 'PayrollController@import')->name('payrolls.import.store');

    // Expensereports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');
});
