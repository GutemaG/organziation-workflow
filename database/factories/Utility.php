<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;
use App\Models\Building;
use App\Models\Bureau;
use App\Models\OnlineRequest;
use App\Models\User;
use Ramsey\Uuid\Type\Integer;

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

    /**
     * return json format of location by creating associative array of latitude and longitude.
     *
     * @param $latitude
     * @param $longitude
     * @return false|string
     */
    public static function getLocation($latitude, $longitude){
        $location = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        return json_encode($location);
    }

    /**
     * get random building and return associative array of its building number and its random office number.
     *
     * @return array
     */
    public static function getBuildingNumberAndOfficeNumber() {
        $building = Building::inRandomOrder()->first();
        return [
            'building_number' => $building->number,
            'office_number' => rand(1, $building->number_of_offices),
        ];
    }

    /**
     * return random bureau id.
     *
     * @return Integer|null
     */
    public static function getBureauId() {
        $bureau = Bureau::inRandomOrder()->first();
        if (empty($bureau))
            return null;
        return $bureau->id;
    }

    /**
     * return user id.
     *
     * @return Integer
     */
    public static function getUserId() {
        return User::inRandomOrder()->first()->id;
    }

    /**
     * return online request id.
     *
     * @return Integer
     */
    public static function getOnlineRequestId() {
        return OnlineRequest::inRandomOrder()->first()->id;
    }

    /**
     * return random value form the given values.
     *
     * @param array $values
     * @return mixed
     */
    public static function getRandomValue(array $values) {
        $index = array_rand($values);
        return $values[$index];
    }
}
