<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Expense;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Requests\UpdateSaleRequest;
use App\Http\Resources\Admin\ExpenseResource;
use App\Models\Sales;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Sales::with(['customer'])->paginate(20));
    }

    public function store(StoreSaleRequest $request)
    {
        $data = $request->all();
        // $data["created_by_id"] = auth('api')->id();
        $expense = Sales::create($data);

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Sales $sale)
    {
        // abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($sale->load(['customer']));
    }
    // public function update(UpdateSaleRequest $request, Sales $sale)
    public function update(UpdateSaleRequest $request, Sales $sale)
    {
        $sale->update($request->all());

        return (new ExpenseResource($sale))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Sales $sale)
    {
        //abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
