<?php

namespace App\Laravel\Services;

use App\Laravel\Models\{User,UserKYC};
use Illuminate\Validation\Validator;

use Hash,PhoneNumber;

class CustomValidator extends Validator{
    /**
     * rule name : current_password
     * @param [0] - id
     *
     */
    public function validateUniqueEmail($attribute, $value, $parameters){
        $email = strtolower($value);
        $id = (is_array($parameters) and isset($parameters[0])) ? $parameters[0] : "0";
        $type = (is_array($parameters) and isset($parameters[1])) ? $parameters[1] : "user";

        switch (strtolower($type)) {
            case 'portal':
                return User::where('email', $email)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            case 'frontend':
                return User::where('email', $email)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            case 'register':
                return UserKYC::where('email', $email)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            default:
                return User::where('email', $email)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
        }
    }

    public function validateCurrentPassword($attribute, $value, $parameters){

        if ($parameters) {
            $user_id = (is_array($parameters) and isset($parameters[0])) ? $parameters[0] : "0";
            $user = User::find($user_id);
            return Hash::check($value, $user->password);
        }
        return false;
    }

    public function validateNewPassword($attribute, $value, $parameters){

        $user_id = (is_array($parameters) and isset($parameters[0])) ? $parameters[0] : "0";
        $user = User::find($user_id);
        return !Hash::check($value, $user->password) ? true : false;
    }

    public function validatePasswordFormat($attribute, $value, $parameters){
        
        return preg_match(("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-.]).{8,}$/"), $value);
    }

    public function validateAllowedCountry($attribute, $value, $parameters){
        $contact_number = new PhoneNumber($value);
        $allowed_countries = explode(",", env("ALLOWED_COUNTRY_CODE", "PH"));
        return in_array($contact_number->getCountry() ?: "PH", $allowed_countries) ? true : false;
    }

    public function validateUniquePhone($attribute, $value, $parameters){
        $id = (is_array($parameters) and isset($parameters[0])) ? $parameters[0] : "0";
        $type = (is_array($parameters) and isset($parameters[1])) ? $parameters[1] : "user";

        try{
            $contact_number = new PhoneNumber($value);

            if (is_null($contact_number->getCountry())) {
                $contact_number = new PhoneNumber($value, "PH");
            }

            $contact_number = $contact_number->formatE164();
        }catch(\Exception $e){
           return false; 
        }

        switch (strtolower($type)) {
            case 'portal':
                return User::where('contact_number', $contact_number)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            case 'frontend':
                return User::where('contact_number', $contact_number)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            case 'register':
                return UserKYC::where('contact_number', $contact_number)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
                break;
            default:
                return User::where('contact_number', $contact_number)
                    ->where('id', '<>', $id)
                    ->count() ? false : true;
        }
    }
}
