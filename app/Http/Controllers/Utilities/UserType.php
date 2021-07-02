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

    /**
     * Get all user type.
     *
     * @return array
     */
    public static function all(){
        return [
            self::$admin,
            self::$itTeam,
            self::$staff,
            self::$reception,
        ];
    }

    /**
     * Get all user type except admin.
     *
     * @return array
     */
    public static function exceptAdmin(){
        return [
            self::$itTeam,
            self::$staff,
            self::$reception,
        ];
    }

    /**
     * Get only major user type (admin and staff).
     *
     * @return array
     */
    public static function majors(){
        return [
            self::$admin,
            self::$itTeam,
        ];
    }

    /**
     * Get only minor user type (staff and reception).
     *
     * @return array
     */
    public static function minors(){
        return [
            self::$staff,
            self::$reception,
        ];
    }

}
