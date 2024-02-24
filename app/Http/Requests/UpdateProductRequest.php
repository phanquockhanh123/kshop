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
            'name' => 'nullable',
            'category_id' => 'nullable|integer|exists:categories,id,deleted_at,NULL',
            'campaign_id' => 'nullable|integer|exists:campaigns,id,deleted_at,NULL',
            'discount_id' => 'nullable|integer|exists:discounts,id,deleted_at,NULL',
            'image' => 'nullable',
            'description' => 'nullable',
            'priority' => 'nullable|integer',
            'size_id' => 'nullable|integer|exists:sizes,id,deleted_at,NULL',
            'color_id' => 'nullable|integer|exists:colors,id,deleted_at,NULL',
            'price' => 'nullable|integer',
            'price_compare' => 'nullable|integer',
        ];
    }
}
