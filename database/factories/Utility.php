<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;
use App\Models\Building;
use App\Models\Bureau;

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
            UserType::getItTeamMember(),
            UserType::getReception(),
            UserType::getStaff()
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
        $buildings = Building::select(['id', 'number_of_offices'])->get();
        $index = rand(1, count($buildings));
        $building = $buildings[$index - 1];
        return [
            'building_number' => $building->id,
            'office_number' => rand(1, $building->number_of_offices),
        ];
    }

    public static function getBureauId() {
        $bureaus = Bureau::select('id')->get();
        $index = rand(0, count($bureaus) - 1);
        if (empty($bureaus))
            return null;
        return $bureaus[$index]->id;
    }
}
