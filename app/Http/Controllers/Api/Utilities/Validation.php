<?php


namespace App\Http\Controllers\Api\Utilities;


use Illuminate\Support\Facades\Validator;
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
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => ['required', 'confirmed', 'string', Rules\Password::defaults()],
            'delete_FAQ' => 'required|boolean',
            'update_FAQ' => 'required|boolean',
            'reply_request' => 'required|boolean',
            'add_request_to_FAQ' => 'required|boolean',
            'delete_request' => 'required|boolean',
            'create_bureau' => 'required|boolean',
            'update_bureau' => 'required|boolean',
            'delete_bureau' => 'required|boolean',
            'create_affair' => 'required|boolean',
            'update_affair' => 'required|boolean',
            'delete_affair' => 'required|boolean',
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
