<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;
use App\Models\Building;
use App\Models\Bureau;
use App\Models\User;

class Utility
{
    /**
     * return random ethiopian phone number.
     *
     * @return string
     */
    public static function getPhoneNumber(){
        $phoneNumber = '+2519';

        for($i = 0; $i < 8; $i++)
            $phoneNumber .= rand(0,9);
        return $phoneNumber;
    }

    /**
     * return random user type.
     * To identify if user is it team member, staff or reception.
     * But it will not include admin type because we assume that admin is created only once.
     *
     * @return String
     */
    public static function getUserType(){
        $userTypes = [
            UserType::itTeam(),
            UserType::reception(),
            UserType::staff()
        ];

        return $userTypes[array_rand($userTypes)];
    }

    public static function getLocation($latitude, $longitude){
        $location = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        return json_encode($location);
    }

    public static function getBuildingNumberAndOfficeNumber() {
        $building = Building::inRandomOrder()->first();
        return [
            'building_number' => $building->number,
            'office_number' => rand(1, $building->number_of_offices),
        ];
    }

    public static function getBureauId() {
        $bureau = Bureau::inRandomOrder()->first();
<<<<<<< HEAD
        // $index = rand(0, count($bureaus) - 1);
=======
>>>>>>> 6b7fba761e5fbb5d4ecf29612adc6d396aa487ff
        if (empty($bureau))
            return null;
        return $bureau->id;
    }

    public static function getUserId() {
        return User::inRandomOrder()->first()->id;
    }
}
