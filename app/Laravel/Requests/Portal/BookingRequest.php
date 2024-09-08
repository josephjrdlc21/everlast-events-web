<?php

namespace App\Laravel\Requests\Portal;

use App\Laravel\Requests\RequestManager;

class BookingRequest extends RequestManager
{
    public function rules()
    {
        $rules = [
            'remarks' => "required"
        ];
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'required'	=> "Field is required."
        ];
    }
}