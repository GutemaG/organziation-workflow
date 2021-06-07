<?php


namespace App\Http\Controllers\Api\Utilities;


use Faker\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        'phone','password',
        'password_confirmation',
    ];

    /**
     * only user permission data
     *
     * @var string[]
     */
    public static $permission_fields = [
        'delete_FAQ',
        'update_FAQ',
        'reply_request',
        'add_request_to_FAQ',
        'delete_request',
        'create_bureau',
        'update_bureau',
        'delete_bureau',
        'create_affair',
        'update_affair',
        'delete_affair',
    ];

    /**
     * returns all fields both user and permission fields
     *
     * @return array
     */
    public static function all(){
        return array_merge(Fields::$user_fields, Fields::$permission_fields);
    }

    /**
     * return all fields except the fields specified in parameter
     *
     * @param array $fields
     * @return array
     */
    public static function except($fields=[]){
        if(empty($fields))
            return Fields::all();

        return collect(Fields::all())->filter(function ($value, $key) use ($fields) {
                return !in_array($value, $fields);
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
//        $data['email_verified_at'] = now()->toDateTimeString();
        return $data;
    }

    /**
     * return mapped array that only contains user permission field only.
     * which is ready to insert into or update permission table
     *
     * @param array $data
     * @return array
     */
    public static function filter_permission_fields(array $data){
        return collect($data)
            ->only(Fields::$permission_fields)
            ->map(function ($value, $key){
                return $value ? true : false;
            })->all();
    }

    public static function permutation(){
        $list = Fields::all();
        $result = array();
        $temp = array();
        foreach ($list as $value){
            if (!in_array($value, $temp))
                array_push($temp, $value);
            foreach ($temp as $item){
                if($item != $value)
                    $result[] = array($item, $value);
            }
        }
        return count($result);
    }
}
