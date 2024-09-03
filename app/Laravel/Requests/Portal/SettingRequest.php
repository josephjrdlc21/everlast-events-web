<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class SettingRequest extends RequestManager
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
        $rules = [
            'brand' => 'required',
            'system' => 'required',
            'logo' => 'nullable|mimes:jpeg,png,jpg|between:1,10240'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
        ];
    }
}
