<?php

namespace App\Http\Controllers\Utilities;

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
     * Getter method of fields for the requested model.
     * But you have to specify model name in small letter.
     *
     * @param $modelName
     * @return string[]|null
     */
    public static function get($modelName) {
        switch ($modelName){
            case 'user':
                return self::$user;
                break;
            case 'building':
                return self::$building;
                break;
            case 'bureau':
                return self::$bureau;
                break;
            default:
                return null;
        }
    }

    /**
     * Get except the specified fields of the requested model.
     * But you have to specify model name in small letter.
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
     * But you have to specify model name in small letter.
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
     * But you have to specify model name in small letter.
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
