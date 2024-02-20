<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCampaignRequest extends FormRequest
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
            'name' => 'required',
            'image' => 'nullable',
            'start_date' => 'required|before_or_equal:end_date',
            'end_date' => 'nullable|after_or_equal:start_time',
            'campaign_budget' => 'required|integer',
            'campaign_description' => 'nullable|string',
        ];
    }
}
