<?php


namespace App\Utilities;


class UserType
{
    /**
     * Create constant variable for user type.
     *
     * @var string
     */
    private static string $admin = "admin";
    private static string $supportiveStaff = "supportive_staff";
    private static string $staff = "staff";
    private static string $reception = "reception";

    /**
     * Getter method for $admin variable.
     *
     * @return string
     */
    public static function admin(): string
    {
        return UserType::$admin;
    }

    /**
     * Getter method for $itTeam variable.
     *
     * @return string
     */
    public static function supportiveStaff(): string
    {
        return UserType::$supportiveStaff;
    }

    /**
     * Getter method for $staff variable.
     *
     * @return string
     */
    public static function staff(): string
    {
        return UserType::$staff;
    }

    /**
     * Getter method for $reception variable.
     *
     * @return string
     */
    public static function reception(): string
    {
        return UserType::$reception;
    }

    /**
     * Get all user type.
     *
     * @return array
     */
    public static function all(): array
    {
        return [
            self::$admin,
            self::$supportiveStaff,
            self::$staff,
            self::$reception,
        ];
    }

    /**
     * Get all user type except admin.
     *
     * @return array
     */
    public static function exceptAdmin(): array
    {
        return [
            self::$supportiveStaff,
            self::$staff,
            self::$reception,
        ];
    }

    /**
     * Get only major user type (admin and staff).
     *
     * @return array
     */
    public static function majors(): array
    {
        return [
            self::$admin,
            self::$supportiveStaff,
        ];
    }

    /**
     * Get only minor user type (staff and reception).
     *
     * @return array
     */
    public static function minors(): array
    {
        return [
            self::$staff,
            self::$reception,
        ];
    }

}
