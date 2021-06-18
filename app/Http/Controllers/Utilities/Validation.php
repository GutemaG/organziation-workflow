<?php


namespace App\Http\Controllers\Utilities;


use App\Http\Controllers\Utilities\UserType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;


class Validation
{
    /**
     * return all necessary rules for validation user registration
     *
     * @return array
     */
    public static function rules(){
        return [
            'user_name' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'type' => ['required', 'string', Rule::in(UserType::getItTeamMember(), UserType::getStaff(), UserType::getReception())],
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255|unique:users',
            'password' => ['required', 'confirmed', 'string', Rules\Password::defaults()],
        ];
    }

    /**
     * return all necessary rules for validation user data updating
     *
     * @return array
     */
    public static function update_rules(){
        return collect(Validation::rules())->except('password')->map(function ($value, $key){
            return str_replace('required', 'nullable', $value);
        })->all();

    }

}
