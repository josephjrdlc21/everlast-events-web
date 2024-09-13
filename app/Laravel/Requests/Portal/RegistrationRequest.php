<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class RegistrationRequest extends RequestManager
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
            'role' => 'required',
            'firstname' => 'required|regex:/^[a-zA-Z0-9.\-\s]+$/|min:2',
            'lastname' => 'required|regex:/^[a-zA-Z0-9.\-\s]+$/|min:2',
            'middlename' => 'nullable|regex:/^[a-zA-Z0-9.\-\s]*$/|min:2',
            'suffix' => 'nullable|regex:/^[a-zA-Z0-9.\-\s]*$/',
            'email' => "required|email:rfc,dns|unique_email:{$id},portal",
            'contact' => "required|phone:PH|unique_phone:{$id},portal"    
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'Field is required.',
            'email.email' => 'Invalid email address.',
            'email.unique_email' => 'Email address is already used.',
            'firstname.regex' => 'Invalid input. Only special characters like period ( . ) and hyphen ( - ) are allowed.',
            'middlename.regex' => 'Invalid input. Only special characters like period ( . ) and hyphen ( - ) are allowed.',
            'lastname.regex' => 'Invalid input. Only special characters like period ( . ) and hyphen ( - ) are allowed.',
            'suffix.regex' => 'Invalid input. Only special characters like period ( . ) and hyphen ( - ) are allowed.',
            'firstname.min' => 'The first name must be at least 2 characters.',
            'middlename.min' => 'The middle name must be at least 2 characters.',
            'lastname.min' => 'The last name must be at least 2 characters.',
            'contact.unique_phone' => "Phone number already exists.",
            'contact.phone' => "Invalid PH phone number."
        ];
    }
}
