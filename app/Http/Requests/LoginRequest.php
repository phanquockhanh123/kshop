<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email_address' => 'required_if:grant_type,' . config('const.grant_type.password')
                . '|max:255|regex:' . config('const.regex_email_admin'),
            'password' => [
                'required_if:grant_type,' . config('const.grant_type.password'),
                'regex:' . config('const.password_regex'),
            ],
            'refresh_token' => 'required_if:grant_type,' . config('const.grant_type.refresh_token') . '|max:255',
            'grant_type' => 'required|max:255|in:' . implode(',', config('const.grant_type')),
        ];
    }

    /**
     * change display default attributes
     *
     * @return array
     */
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
            'required_if' => sprintf(trans('messages.MsgErr001'), ':attribute'),
            'email_address.regex' => sprintf(trans('messages.MsgErr007'), ':attribute'),
            'password.regex' => trans('messages.MsgErr009'),
        ];
    }
}
