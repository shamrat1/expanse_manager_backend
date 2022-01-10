<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeCategoryRequest;
use App\Http\Requests\StoreIncomeCategoryRequest;
use App\Http\Requests\UpdateIncomeCategoryRequest;
use App\Category;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncomeCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('income_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $incomeCategories = Category::where('type','income')->get();

        return view('admin.incomeCategories.index', compact('incomeCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('income_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.incomeCategories.create');
    }

    public function store(StoreIncomeCategoryRequest $request)
    {
        $data = $request->all();
        $data["type"] = "income";
        $incomeCategory = Category::create($data);

        return redirect()->route('admin.income-categories.index');
    }

    public function edit(Category $incomeCategory)
    {
        abort_if(Gate::denies('income_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $incomeCategory->load('created_by');

        return view('admin.incomeCategories.edit', compact('incomeCategory'));
    }

    public function update(UpdateIncomeCategoryRequest $request, Category $incomeCategory)
    {
        $incomeCategory->update($request->all());

        return redirect()->route('admin.income-categories.index');
    }

    public function show(Category $incomeCategory)
    {
        abort_if(Gate::denies('income_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $incomeCategory->load('created_by');

        return view('admin.incomeCategories.show', compact('incomeCategory'));
    }

    public function destroy(Category $incomeCategory)
    {
        abort_if(Gate::denies('income_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $incomeCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
