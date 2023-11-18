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
            'category_id' => 'nullable|integer|exists:categories,id,deleted_at,NULL',
            'discount_id' => 'nullable|integer|exists:discounts,id,deleted_at,NULL',
            'campaign_id' => 'nullable|integer|exists:campaigns,id,deleted_at,NULL',
            'name' => 'nullable|string|max:255',
            'price' => 'nullable|integer',
            'filepath' => 'nullable|file|max:2048|mimes:jpeg,png,jpg',
            'description' => 'nullable|string|max:255',
            'priority' => 'nullable|integer'
        ];
    }
}
