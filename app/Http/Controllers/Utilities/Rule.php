<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Validation\Rule as BaseRule;
use Illuminate\Validation\Rules;


class Rule
{
    /**
     * return all necessary rules for validating user fields.
     *
     * @return array
     */
    public static function user(){
        return [
            'user_name' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'type' => ['required', 'string', BaseRule::in(UserType::exceptAdmin())],
            'email' => 'nullable|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255|unique:users',
            'password' => ['required', 'confirmed', 'string', Rules\Password::defaults()],
        ];
    }

    /**
     * return all necessary rules for validating building fields.
     *
     * @return string[]
     */
    public static function building(){
        return [
            'name' => 'nullable|string|max:255|unique:buildings',
            'number' => 'required|string|max:10|unique:buildings',
            'number_of_offices' => 'required|integer',
            'description' => 'nullable|string',
        ];
    }

    /**
     * return all necessary rules for validating bureau fields.
     *
     * @return array
     */
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

    /**
     * return all necessary rules for validating fields of requested model.
     * But you have to specify model name in small letter.
     *
     * @param $modelName
     * @return array|string[]|null
     */
    public static function get($modelName) {
        switch ($modelName){
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

    /**
     * return only specified fields rules of requested model.
     * But you have to specify model name in small letter.
     *
     * @param $modelName
     * @param array $fields
     * @return array
     */
    public static function only($modelName, array $fields){
        $rules = self::get($modelName);
        return collect(collect($rules))->only($fields)->all();
    }
}
