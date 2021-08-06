<?php


namespace App\Utilities;


class RequestType
{
    private static  $student = 'student';
    private static  $teacher = 'teacher';
    private static  $staff = 'staff';
    private static  $others = 'other';

    /**
     * @return string
     */
    public static function getStudent(): string
    {
        return self::$student;
    }

    /**
     * @return string
     */
    public static function getTeacher(): string
    {
        return self::$teacher;
    }

    /**
     * @return string
     */
    public static function getStaff(): string
    {
        return self::$staff;
    }

    /**
     * @return string
     */
    public static function getOthers(): string
    {
        return self::$others;
    }

    public static function all(): array
    {
        return [
          self::$staff,
          self::$teacher,
          self::$student,
          self::$others,
        ];
    }

}