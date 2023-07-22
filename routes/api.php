<?php
use App\Http\Controllers\Api\V1\Admin\SalesApiController;

// use Illuminate\Routing\Route;

// Route::get('/v1/api/login', '');
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\User', 'middleware' => ['guest']], function () {
    Route::post('login', 'AuthenticationController@login');
    Route::post('register', 'AuthenticationController@register');
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\User', 'middleware' => ['auth:api']], function () {
    // Home
    Route::get('/home', 'HomeController@index');

    Route::apiResource('categories', "CategoryController");
    Route::apiResource('todo', "TodoController");
    Route::get("transactions/{type?}", "TransactionController@index");
    Route::post('logout', 'AuthenticationController@logout');
});
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Expensecategories
    Route::apiResource('expense-categories', 'ExpenseCategoryApiController');

    // Incomecategories
    Route::apiResource('income-categories', 'IncomeCategoryApiController');

    // Expenses
    Route::apiResource('expenses', 'ExpenseApiController');

    // Incomes
    Route::apiResource('incomes', 'IncomeApiController');

    // Expensereports
    Route::apiResource('expense-reports', 'ExpenseReportApiController');

});
// for local test
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'],function () {
    Route::apiResource('sales', 'SalesApiController');
});
