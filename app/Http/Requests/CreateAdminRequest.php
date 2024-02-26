<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRequest extends FormRequest
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
            'name' => 'required|string',
            'gender' => 'required|integer',
            'email_address' => 'required|string|unique:admins',
            'date_of_birth' => 'required|date|before_or_equal:' . now(),
            'telephone' => 'required|string',
            'image' => 'nullable'
        ];
    }
}
