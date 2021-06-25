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
    public static $user_fields = [
        'user_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'type',
        'password',
        'password_confirmation',
    ];

    public static $building = [
        'number',
        'number_of_offices',
    ];

    /**
     * returns all fields user fields
     *
     * @return array
     */
    public static function all(){
        return Fields::$user_fields;
    }

    /**
     * return all fields except the fields specified in parameter
     *
     * @param array $fields
     * @return array
     */
    public static function except($fields=[]){
        if(empty($fields))
            return self::$user_fields;

        return collect(self::all())->filter(function ($value, $key) use ($fields) {
                return !in_array($value, $fields);
            })->values()->all();
    }

    public static function only($fields=[]){
        if(empty($fields))
            return self::$user_fields;

        return collect(self::all())->filter(function ($value, $key) use ($fields) {
            return in_array($value, $fields);
        })->values()->all();
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
        $data = collect($data)->only(Fields::$user_fields)->all();
        return $data;
    }

}
