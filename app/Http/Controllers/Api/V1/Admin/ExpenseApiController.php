<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Expense;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Resources\Admin\ExpenseResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Expense::with(['category', 'created_by'])->paginate(20));
    }

    public function store(StoreExpenseRequest $request)
    {
        $data = $request->all();
        $data["created_by_id"] = auth('api')->id();
        $expense = Expense::create($data);

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Expense $expense)
    {
        abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($expense->load(['category', 'created_by']));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->all());

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Expense $expense)
    {
        abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expense->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
