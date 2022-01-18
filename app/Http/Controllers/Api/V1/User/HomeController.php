<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Income;
use App\Expense;

class HomeController extends Controller
{
    public function index()
    { 
        $date = Carbon::now()->startOfMonth();
        $income = Income::where('entry_date','>=',$date)->sum('amount');
        $expenses = Expense::where('entry_date', '>=', $date)->pluck('amount');
        $recentExpanses = Expense::with('category')->where('entry_date', '>=', $date)->latest()->limit(5)->get();
        // $expense_amount = $expenses->pluck('amount');
        return response()->json([
            "incomeTotal" => $income,
            "expenseTotal" => $expenses->sum(),
            "recentExpenses" => $recentExpanses,
            "expenseArray" => $expenses,
        ]);
    }
}
