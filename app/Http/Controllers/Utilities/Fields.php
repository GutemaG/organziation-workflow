<?php

namespace App\Http\Controllers\Utilities;

use App\Models\Building;
use App\Models\Bureau;
use App\Models\OnlineRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class Fields
{
    /**
     * User model updatable fields.
     *
     * @var string[]
     */
    private static $user = [
        'user_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'type',
        'password',
        'password_confirmation',
    ];

    /**
     * Building model updatable fields.
     *
     * @var string[]
     */
    private static $building = [
        'name',
        'number',
        'number_of_offices',
        'description',
    ];

    /**
     * Bureau model updatable fields.
     *
     * @var string[]
     */
    private static $bureau = [
        'name',
        'description',
        'accountable_to',
        'location',
        'building_number',
        'office_number',
    ];

    /**
     * OnlineRequest model updatable fields.
     *
     * @var string[]
     */
    private static $onlineRequest = [
        'name',
        'description',
        'online_request_procedures.*.responsible_bureau_id',
        'online_request_procedures.*.description',
        'online_request_procedures.*.step_number',
        'online_request_procedures.*.responsible_user_id.*.user_id',
        'prerequisite_labels.*.label',
    ];

    /**
     * Getter method for $user variable.
     *
     * @return string[]
     */
    public static function user()
    {
        return self::$user;
    }

    /**
     * Getter method for $building variable.
     *
     * @return string[]
     */
    public static function building()
    {
        return self::$building;
    }

    /**
     * Getter method for $bureau variable.
     *
     * @return string[]
     */
    public static function bureau() {
        return self::$bureau;
    }

    /**
     * Getter method for $onlineRequest variable.
     *
     * @return string[]
     */
    public static function onlineRequest() {
        return self::$onlineRequest;
    }

    /**
     * Getter method of fields for the requested model.
     *
     * @param $modelName
     * @return string[]|null
     */
    public static function get($modelName) {
        switch ($modelName){
            case User::class:
                return self::$user;
                break;
            case Building::class:
                return self::$building;
                break;
            case Bureau::class:
                return self::$bureau;
                break;
            case OnlineRequest::class:
                return self::$onlineRequest;
                break;
            default:
                return null;
        }
    }

    /**
     * Get except the specified fields of the requested model.
     *
     * @param $modelName
     * @param $fields
     * @return array|string[]|null
     */
    public static function except($modelName, array $fields){
        $data = self::get($modelName);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {
                return !in_array($value, $fields);
            })->values()->all();
    }

    /**
     * Get only the specified fields of the requested model.
     *
     * @param $modelName
     * @param $fields
     * @return array|string[]|null
     */
    public static function only($modelName, array $fields){
        $data = self::get($modelName);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($value, $fields);
        })->values()->all();
    }

    /**
     * Get all combination of fields for the requested model.
     *
     * @param $modelName
     * @return array[]
     */
    public static function allCombinationOfFields($modelName) {
        $fields = self::get($modelName);
        $results = array(array( ));

        foreach ($fields as $element)
            foreach ($results as $combination)
                array_push($results, array_merge(array($element), $combination));

        return $results;
    }

    /**
     * return mapped array that only contains user field only.
     * which is ready to be inserted or updated into user table.
     *
     * @param array $data
     * @return array
     */
    public static function filterUserFields(array $data){
        if(array_key_exists('password', $data))
            $data['password'] = Hash::make($data['password']);
        $data = collect($data)->only(self::$user)->all();
        return $data;
    }

}
