<?php

namespace App\Http\Requests;

use App\Sale;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required', 'exists:users,id',
            ],
            'date' => [
                'nullable', 'date_format:' . config('panel.date_format'),
            ],
            'customer_id' => [
                'nullable', 'exists:customers,id',
            ],
            'company_id' => [
                'nullable',
                // 'exists:companies,id',
            ],
            'quantity' => [
                'required',
            ],
            'rate' => [
                'nullable',
            ],
            'total_amount' => [
                'required',
            ],
            'discount' => [
                'nullable',
            ],
            'total_payment' => [
                'nullable',
            ],
            'paid' => [
                'nullable',
            ],
            'due' => [
                'nullable',
            ],
        ];
    }
}
