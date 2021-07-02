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

    public static function allCombinationOfData() {
        $array = ['number', 'number_of_offices'];
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

}
