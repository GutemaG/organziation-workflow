<?php


namespace App\Utilities;


class InputFieldType
{
    private static string $file = 'file';
    private static string $text = 'text';
    private static string $number = 'number';
    private static string $email = 'email';

    /**
     * @return string
     */
    public static function getFile(): string
    {
        return self::$file;
    }

    /**
     * @return string
     */
    public static function getText(): string
    {
        return self::$text;
    }

    /**
     * @return string
     */
    public static function getNumber(): string
    {
        return self::$number;
    }

    /**
     * @return string
     */
    public static function getEmail(): string
    {
        return self::$email;
    }

    public static function all(): array
    {
        return [
          self::$email,
//          self::$file,
          self::$number,
          self::$text,
        ];
    }

    public static function random(): string
    {
        $types = self::all();
        return $types[array_rand($types)];
    }
}
