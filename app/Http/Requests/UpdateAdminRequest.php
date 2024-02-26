<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $id = $this->id;
        return [
            'name' => 'nullable|string',
            'gender' => 'nullable|integer',
            'email_address' => 'nullable|string|unique:admins,email_address,'. $id . 'id',
            'date_of_birth' => 'nullable|date|before_or_equal:' . now(),
            'telephone' => 'nullable|string',
            'image' => 'nullable'
        ];
    }
}
