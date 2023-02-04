<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
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
            'email_address' => 'required|regex:' . config('const.regex_email_admin'),
        ];
    }

    public function attributes()
    {
        return [
            'email_address' => 'Email',
        ];
    }

    /**
     * Custom messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email_address.required' => sprintf(trans('messages.MsgErr001'), ':attribute'),
            'email_address.regex' => sprintf(trans('messages.MsgErr007'), ':attribute'),
        ];
    }
}
