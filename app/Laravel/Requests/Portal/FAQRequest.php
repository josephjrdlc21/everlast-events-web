<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class FAQRequest extends RequestManager
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
            'question' => "required",
            'answer' => "required",
            'status' => "required"
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
