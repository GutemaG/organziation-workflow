<?php


namespace App\Http\Controllers\Utilities;


class UserType
{
    /**
     * Create constant variable for user type.
     *
     * @var string
     */
    private static $admin = "admin";
    private static $itTeam = "it_team_member";
    private static $staff = "staff";
    private static $reception = "reception";

    /**
     * Getter method for $admin variable.
     *
     * @return string
     */
    public static function admin()
    {
        return UserType::$admin;
    }

    /**
     * Getter method for $itTeam variable.
     *
     * @return string
     */
    public static function itTeam()
    {
        return UserType::$itTeam;
    }

    /**
     * Getter method for $staff variable.
     *
     * @return string
     */
    public static function staff()
    {
        return UserType::$staff;
    }

    /**
     * Getter method for $reception variable.
     *
     * @return string
     */
    public static function reception()
    {
        return UserType::$reception;
    }

    public static function all(){
        return [
            self::$admin,
            self::$itTeam,
            self::$staff,
            self::$reception,
        ];
    }

}
