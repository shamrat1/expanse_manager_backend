<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\Http\Controllers\Controller;
use App\Income;
use Carbon\Carbon;

class ExpenseReportController extends Controller
{
    public function index()
    {
        $from = Carbon::parse(sprintf(
            '%s-%s-01',
            request()->query('y', Carbon::now()->year),
            request()->query('m', Carbon::now()->month)
        ));
        $to      = clone $from;
        $to->day = $to->daysInMonth;

        $expenses = Expense::with('category')
            ->whereBetween('entry_date', [$from, $to]);

        $incomes = Income::with('category')
            ->whereBetween('entry_date', [$from, $to]);

        $expensesTotal   = $expenses->sum('amount');
        $incomesTotal    = $incomes->sum('amount');
        $groupedExpenses = $expenses->whereNotNull('category_id')->orderBy('amount', 'desc')->get()->groupBy('category_id');
        $groupedIncomes  = $incomes->whereNotNull('category_id')->orderBy('amount', 'desc')->get()->groupBy('category_id');
        $profit          = $incomesTotal - $expensesTotal;

        $expensesSummary = [];

        foreach ($groupedExpenses as $exp) {
            foreach ($exp as $line) {
                if (!isset($expensesSummary[$line->category->name])) {
                    $expensesSummary[$line->category->name] = [
                        'name'   => $line->category->name,
                        'amount' => 0,
                    ];
                }

                $expensesSummary[$line->category->name]['amount'] += $line->amount;
            }
        }

        $incomesSummary = [];

        foreach ($groupedIncomes as $inc) {
            foreach ($inc as $line) {
                if (!isset($incomesSummary[$line->category->name])) {
                    $incomesSummary[$line->category->name] = [
                        'name'   => $line->category->name,
                        'amount' => 0,
                    ];
                }

                $incomesSummary[$line->category->name]['amount'] += $line->amount;
            }
        }

        return view('admin.expenseReports.index', compact(
            'expensesSummary',
            'incomesSummary',
            'expensesTotal',
            'incomesTotal',
            'profit'
        ));
    }
}
