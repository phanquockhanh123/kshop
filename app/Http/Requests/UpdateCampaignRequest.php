<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCampaignRequest extends FormRequest
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
            'status' => 'nullable',
            'filepath' => 'nullable',
            'photo_name' => 'nullable',
            'start_date' => 'nullable|before_or_equal:end_date',
            'end_date' => 'nullable|after_or_equal:start_time',
            'campaign_budget' => 'nullable|integer',
            'campaign_description' => 'nullable|string',
        ];
    }
}
