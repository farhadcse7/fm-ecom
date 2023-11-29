<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'coupon_name' => 'required|string|max:255|unique:coupons,coupon_name',
            'discount_amount' => 'required|numeric',
            'minimum_purchase_amount' => 'required|numeric',
            'validity_till' => 'required|date',
        ];
    }
}
