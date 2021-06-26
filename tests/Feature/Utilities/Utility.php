<?php


namespace Tests\Feature\Utilities;


use App\Http\Controllers\Utilities\Fields;

class Utility
{
    public static function allCombinationOfUserData() {
        $array = Fields::all();
        $results = array(array( ));

        foreach ($array as $element)
            foreach ($results as $combination)
                array_push($results, array_merge(array($element), $combination));

        return $results;
    }

    private static function errors(){
        return[
            'user_name' => [
                "The user name field is required."
            ],
            'first_name' => [
                "The first name field is required."
            ],
            'last_name' => [
                "The last name field is required."
            ],
            'type' => [
                "The type field is required."
            ],
            'password' => [
                "The password field is required."
            ],
        ];
    }

    public static function getErrors(array $field){
        return collect(self::errors())->filter(function ($value, $key) use ($field) {
            return in_array($key, $field);
        })->all();
    }

    public static function t(){
        $user = FakeDataGenerator::userData();
        $data = [
            "user_name" => $user['user_name'],
            "first_name" => $user['first_name'],
            "last_name" => $user['last_name'],
            "email" => $user['email'],
            "phone" => $user['phone'],
            'type' => $user['type'],
        ];
        return collect($data)->except('email')->all();
    }
}
