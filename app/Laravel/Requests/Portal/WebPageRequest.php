<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class WebPageRequest extends RequestManager
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
        $id = $this->id ?? 0;

        $rules = [
            'type' => "required|unique_page:{$id}",
            'content' => "required",
            'title' => "required"
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => "Field is required.",
            'type.unique_page' => "This page is already exist. Cannot use the same page."
        ];
    }
}
