<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        // abort_if(Gate::denies('sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
        'user_id' => [
            'nullable'],
        'date'  => [
            'nullable', 'date_format:' . config('panel.date_format'),
        ],
        'purchase_id' => [
            'nullable'],
        'quantity' => [
            'nullable'],
        'rate' => [
            'nullable'],
        'total_amount' => [
            'nullable'],
        'discount' => [
            'nullable'],
        'total_payment' => [
            'nullable'],
        'paid' => [
            'nullable'],
        'due' => [
            'nullable'],
        'prev_due' => [
            'nullable'],
        ];
    }
}
