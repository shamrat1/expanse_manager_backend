<?php

namespace App\Http\Controllers\Admin;

use App\Expense;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseRequest;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Imports\ExpensesImport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenses = Expense::all();

        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        abort_if(Gate::denies('expense_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense_categories = Category::where('type','expanse')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.expenses.create', compact('expense_categories'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function edit(Expense $expense)
    {
        abort_if(Gate::denies('expense_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense_categories = Category::where('type','expanse')->get()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $expense->load('category', 'created_by');

        return view('admin.expenses.edit', compact('expense_categories', 'expense'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return redirect()->route('admin.expenses.index');
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->load('category', 'created_by');

        return view('admin.expenses.show', compact('expense'));
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseRequest $request)
    {
        Expense::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function importView(){

        return view('admin.expenses.import');
    }
    public function import(Request $request){


        $file = $request->file('file');
        try{

            Excel::import(new ExpensesImport, $file);
            return back()->with("success","Expense Data Inserted Successfully!");
        }
        catch (Exception $e){
            return back()->with("error",$e->getMessage());
        }
        // return redirect()->route('admin.expenses.index');
    }
}
