<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'nullable|string',
            'category_id' => 'required|integer|exists:categories,id,deleted_at,NULL',
            'campaign_id' => 'nullable|integer|exists:campaigns,id,deleted_at,NULL',
            'discount_id' => 'nullable|integer|exists:discounts,id,deleted_at,NULL',
            'image' => 'nullable',
            'description' => 'required',
            'priority' => 'required|integer',
            'price' => 'required|integer|lt:price_compare',
            'price_compare' => 'required|integer|gt:price',
            'weight' => 'required|integer',
            'is_ship' => 'required|integer',
            'price_more' => 'required|integer',
            'size_id' => 'required|array',
            'size_id.*' => 'required|integer|exists:sizes,id,deleted_at,NULL',
            'color_id' => 'required|array',
            'color_id.*' => 'required|integer|exists:colors,id,deleted_at,NULL',
            'quantity' => 'required|integer'
        ];
    }
}
