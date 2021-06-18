<?php


namespace Database\Factories;


use App\Http\Controllers\Utilities\UserType;

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
}
