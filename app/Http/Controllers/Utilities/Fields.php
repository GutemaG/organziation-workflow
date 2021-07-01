<?php


namespace App\Http\Controllers\Utilities;


use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Self_;

class Fields
{
    /**
     * only user data fields
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

    private static $building = [
        'name',
        'number',
        'number_of_offices',
        'description',
    ];

    private static $bureau = [
        'name',
        'description',
        'accountable_to',
        'location',
        'building_number',
        'office_number',
    ];

    /**
     * @return string[]
     */
    public static function user()
    {
        return self::$user;
    }

    /**
     * @return string[]
     */
    public static function building()
    {
        return self::$building;
    }

    public static function bureau() {
        return self::$bureau;
    }


    public static function get($table) {
        switch ($table){
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
     * returns all fields user fields
     *
     * @return array
     */
    public static function all(){
        return Fields::$user;
    }


    public static function except($table, $fields=[]){
        $data = self::get($table);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {
                return !in_array($value, $fields);
            })->values()->all();
    }

    public static function only($table, $fields=[]){
        $data = self::get($table);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($value, $fields);
        })->values()->all();
    }

    public static function allCombinationModelFields($table) {
        $fields = self::get($table);
        $results = array(array( ));

        foreach ($fields as $element)
            foreach ($results as $combination)
                array_push($results, array_merge(array($element), $combination));

        return $results;
    }

    /**
     * return mapped array that only contains user field only.
     * which is ready to insert into or update user table
     *
     * @param array $data
     * @return array
     */
    public static function filter_user_fields(array $data){
        if(array_key_exists('password', $data))
            $data['password'] = Hash::make($data['password']);
        $data = collect($data)->only(Fields::$user)->all();
        return $data;
    }

}
