<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id,deleted_at,NULL',
            'discount_id' => 'required|integer|exists:discounts,id,deleted_at,NULL',
            'campaign_id' => 'required|integer|exists:campaigns,id,deleted_at,NULL',
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'filepath' => 'nullable|file|max:2048|mimes:jpeg,png,jpg',
            'description' => 'nullable|string|max:255',
            'priority' => 'nullable|integer'
        ];
    }
}
