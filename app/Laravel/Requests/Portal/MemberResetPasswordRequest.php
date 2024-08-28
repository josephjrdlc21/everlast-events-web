<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class MemberResetPasswordRequest extends RequestManager
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
        $id = $this->id ? : 0;

		$rules = [
            'password' => "required|confirmed|password_format|new_password:{$id}",
		];

        return $rules;
    }

    public function messages()
    {
        return [
            'required'	=> "Field is required.",
			'confirmed' => "Password mismatch.",
			'password_format' => "Password must be atleast 8 characters long, should contain atleast 1 uppercase, 1 lowercase, 1 numeric and 1 special character.",
            'password.new_password' => "You are not allowed to use the same password."
        ];
    }
}
