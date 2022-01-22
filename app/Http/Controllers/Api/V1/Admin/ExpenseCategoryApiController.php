<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Http\Resources\Admin\ExpenseCategoryResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseCategoryResource(Category::where("type","expanse")->with(['created_by'])->get());
    }

    public function store(StoreExpenseCategoryRequest $request)
    {
        $expenseCategory = Category::create($request->all());

        return (new ExpenseCategoryResource($expenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Category $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseCategoryResource($expenseCategory->load(['created_by']));
    }

    public function update(UpdateExpenseCategoryRequest $request, Category $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return (new ExpenseCategoryResource($expenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Category $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
