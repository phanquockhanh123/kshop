<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token' => 'required|max:255',
            'password' => ['required', 'confirmed', 'regex:' . config('const.password_regex')],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'password.required' => sprintf(trans('messages.MsgErr001'), ':attribute'),
            'password.regex' => trans('messages.MsgErr009'),
            'password.confirmed' => trans('messages.MsgErr010'),
        ];
    }
}
