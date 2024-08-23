<?php

namespace App\Laravel\Services;

use App\Laravel\Models\User;
use Illuminate\Validation\Validator;
use Hash;

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
}
