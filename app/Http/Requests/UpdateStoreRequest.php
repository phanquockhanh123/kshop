<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
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
            'name'      => 'nullable|string',
            'phone'     => 'nullable|string',
            'address'   => 'nullable|string',
            'country'   => 'nullable|string',
            'province'  => 'nullable|string',
            'district'  => 'nullable|string',
            'wards'     => 'nullable|string',
        ];
    }
}
