<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExpenseCategoryRequest;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategories = Category::where('type','expanse')->get();

        return view('admin.expenseCategories.index', compact('expenseCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('expense_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.expenseCategories.create');
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $data = $request->all();
        $data["type"] = "expanse";
        $expenseCategory = Category::create($data);

        return redirect()->route('admin.expense-categories.index');
    }

    public function edit(Category $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->load('created_by');

        return view('admin.expenseCategories.edit', compact('expenseCategory'));
    }

    public function update(UpdateExpenseCategoryRequest $request, Category $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return redirect()->route('admin.expense-categories.index');
    }

    public function show(Category $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->load('created_by');

        return view('admin.expenseCategories.show', compact('expenseCategory'));
    }

    public function destroy(Category $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyExpenseCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
