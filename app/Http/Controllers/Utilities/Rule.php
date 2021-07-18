<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Validation\Rule as BaseRule;
use Illuminate\Validation\Rules;

use App\Models\Building;
use App\Models\Bureau;
use App\Models\User;


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

    public static function onlineRequest() {
        return [
            'name' => 'required|string|max:300|unique:online_requests',
            'description' => 'required|string',
            'online_request_procedures.*.responsible_bureau_id' => ['required', 'integer', BaseRule::exists('bureaus', 'id')],
            'online_request_procedures.*.description' => 'nullable|string',
            'online_request_procedures.*.step_number' => 'required|integer',
            'online_request_procedures.*.responsible_user_id.*' => ['required', 'integer', BaseRule::exists('users', 'id')],
            'prerequisite_labels.*' => 'nullable|string',
        ];
    }

    /**
     * return all necessary rules for validating fields of requested model.
     *
     * @param $modelName
     * @return array|string[]|null
     */
    public static function get($modelName) {
        switch ($modelName){
            case User::class:
                return self::user();
                break;
            case Building::class:
                return self::building();
                break;
            case Bureau::class:
                return self::bureau();
                break;
            default:
                return null;
        }
    }

    /**
     * return only specified fields rules of requested model.
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
