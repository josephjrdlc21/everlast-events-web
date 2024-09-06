<?php

namespace App\Laravel\Requests\Frontend;

use App\Laravel\Requests\RequestManager;

class BookingRequest extends RequestManager
{
    public function rules()
    {
        $rules = [
            'event_id' => "required",
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