<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Models\Payroll;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayrollRequest;
use App\Http\Resources\Admin\ExpenseResource;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class PayrollApiController extends Controller
{
    public function index()
    {
        // abort_if(Gate::denies('expense_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource(Payroll::paginate(20));
    }

    // public function store(StorePayrollRequest $request)
    public function store(StorePayrollRequest $request)
    {
        $data = $request->all();
        // $data["user_id"] = auth('api')->id();
        $expense = Payroll::create($data);

        return (new ExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Payroll $Payroll)
    {
        // abort_if(Gate::denies('expense_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseResource($Payroll->load(['employee']));
    }
    // public function update(UpdatePayrollRequest $request, Payroll $Payroll)
    public function update(StorePayrollRequest $request, Payroll $Payroll)
    {
        $Payroll->update($request->all());

        return (new ExpenseResource($Payroll))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Payroll $Payroll)
    {
        //abort_if(Gate::denies('expense_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $Payroll->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
