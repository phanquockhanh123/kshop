<?php

namespace App\Http\Requests;

use App\Rules\ValidateDiscountValue;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            // 'discount_type' => 'nullable',
            // 'discount_value' => [
            //     'required_if:discount_type,1',
            //     new ValidateDiscountValue
            // ],
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'required|after_or_equal:start_time'
        ];
    }
}
