<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Purchase;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Http\Resources\Admin\ExpenseResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Purchase::paginate(20));
    }

    // public function store(StorePurchaseRequest $request)
    public function store(StorePurchaseRequest $request)
    {
        $data = $request->all();
        $data["user_id"] = auth('api')->id();
        $expense = Purchase::create($data);

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Purchase $purchase)
    {
        // abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($purchase->load(['customer']));
    }
    // public function update(UpdatePurchaseRequest $request, Purchase $Purchase)
    public function update(StorePurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());

        return (new ExpenseResource($purchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Purchase $purchase)
    {
        //abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
