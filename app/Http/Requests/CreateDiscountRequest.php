<?php

namespace App\Http\Requests;

use App\Models\Discount;
use App\Rules\ValidateDiscountValue;
use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            //'discount_type' => 'required|in: ' . implode(',', array_values(Discount::$discountType)),
            // 'discount_type' => 'required',
            // 'discount_value' => [
            //     'required',
            //     new ValidateDiscountValue
            // ],
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'nullable|after_or_equal:start_time'
        ];
    }
}
