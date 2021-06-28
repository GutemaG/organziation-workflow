<?php


namespace App\Http\Controllers\Utilities;


class UserType
{
    private static $admin = "admin";
    private static $it_team_member = "it_team_member";
    private static $staff = "staff";
    private static $reception = "reception";

    /**
     * @return string
     */
    public static function getAdmin()
    {
        return UserType::$admin;
    }

    /**
     * @return string
     */
    public static function getItTeamMember()
    {
        return UserType::$it_team_member;
    }

    /**
     * @return string
     */
    public static function getStaff()
    {
        return UserType::$staff;
    }

    /**
     * @return string
     */
    public static function getReception()
    {
        return UserType::$reception;
    }

}
