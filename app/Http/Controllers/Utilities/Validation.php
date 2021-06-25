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
     * @param array $fields
     * @return array
     */
    public static function update_rules($fields=[]){
        return collect(collect(Validation::rules()))->only($fields)->all();
    }

    public static function buildingRules(){
        return [
            'number' => 'required|string|max:10|unique:buildings',
            'number_of_offices' => 'required|integer',
        ];
    }

    public static function buildingUpdateRules($fields=[]){
        return collect(collect(Validation::buildingRules()))->only($fields)->all();
    }

}
