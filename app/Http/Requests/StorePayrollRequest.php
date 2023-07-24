<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePayrollRequest extends FormRequest
{
    public function authorize()
    {
        // abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        'month' => [
            'required'],
        'pay' => [
            'nullable'],
        'total_worked_days' => [
            'nullable'],
        'overtime_rate' => [
            'nullable'],
        'total_overtime_days' => [
            'nullable'],
        'overtime_pay' => ['nullable'],
        'gross_pay' => ['nullable'],
        'deductibles' => ['nullable'],
        'net_pay' => ['nullable'],
        'paid' => [
            'nullable'],
        'due' => [
            'nullable'],
        'employee_id' => [
            'nullable'],
            'company_id' => [
                'nullable'],
        ];
    }
}
