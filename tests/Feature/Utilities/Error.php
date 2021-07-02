<?php


namespace Tests\Feature\Utilities;


class Error
{
    private static $bureau = [
        "name" => [
            "The name field is required."
        ],
        "description" => [
            "The description field is required."
        ],
        "building_number" => [
            "The building number field is required."
        ],
        "office_number" => [
            "The office number field is required."
        ],
    ];

    private static $building = [
        'number_of_offices' => ['The number of offices field is required.'],
        'number' => ['The number field is required.']
    ];

    public static function get($table) {
        switch ($table){
//            case 'user':
//                return self::$user;
//                break;
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


    public static function except($table, $fields=[]){
        $data = self::get($table);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {

            return !in_array($key, $fields);
        })->all();
    }

    public static function only($table, $fields=[]){
        $data = self::get($table);

        if(empty($fields))
            return $data;

        return collect($data)->filter(function ($value, $key) use ($fields) {
            return in_array($key, $fields);
        })->all();
    }
}
