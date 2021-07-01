<?php


namespace App\Http\Controllers\Utilities;


use App\Http\Controllers\Utilities\UserType;
use Illuminate\Validation\Rule as BaseRule;
use Illuminate\Validation\Rules;


class Rule
{
    /**
     * return all necessary rules for validation user registration
     *
     * @return array
     */
    public static function user(){
        return [
            'user_name' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'type' => ['required', 'string', BaseRule::in(UserType::getItTeamMember(), UserType::getStaff(), UserType::getReception())],
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255|unique:users',
            'password' => ['required', 'confirmed', 'string', Rules\Password::defaults()],
        ];
    }

    public static function building(){
        return [
            'name' => 'nullable|string|max:255|unique:buildings',
            'number' => 'required|string|max:10|unique:buildings',
            'number_of_offices' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }

    public static function bureau() {
        return [
            'name' => 'required|string|max:255|unique:bureaus',
            'description' => 'required|string',
            'accountable_to' => ['nullable', 'integer', BaseRule::exists('bureaus', 'id')],
            'location' => 'nullable|string',
            'building_number' => ['required', 'string', BaseRule::exists('buildings', 'number')],
            'office_number' => 'required|string',
        ];
    }

    public static function get($table) {
        switch ($table){
            case 'user':
                return self::user();
                break;
            case 'building':
                return self::building();
                break;
            case 'bureau':
                return self::bureau();
                break;
            default:
                return null;
        }
    }


    public static function update($table, $fields=[]){
        $rules = self::get($table);
        return collect(collect($rules))->only($fields)->all();
    }
}
