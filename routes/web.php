<?php

use App\Expense;

Route::redirect('/', '/login');
Route::redirect('/home', '/admin');
Auth::routes();

Route::get('/test',function(){
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

    // Incomes
    Route::delete('incomes/destroy', 'IncomeController@massDestroy')->name('incomes.massDestroy');
    Route::resource('incomes', 'IncomeController');

    // Expensereports
    Route::delete('expense-reports/destroy', 'ExpenseReportController@massDestroy')->name('expense-reports.massDestroy');
    Route::resource('expense-reports', 'ExpenseReportController');
});
