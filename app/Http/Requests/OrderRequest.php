<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'number' => 'required',
            'district ' => 'required',
            'city' => 'required',
            'delivery_method' => 'required|in:delivery,pickup',
            'town' => 'required',
            'adres' => 'required',
            'orient' => 'required',
            'work_adres' => 'required',
            'comment' => 'nullable',
            'coupon' => 'nullable',
            'status' => 'required',
            'tires' => 'required',
            'payment_method' => 'required|in:cash,transfer',
        ];
    }
}
