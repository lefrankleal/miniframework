<?php
namespace Core\Helpers;

class Crypt
{
    public static function cryptPassword($string, $method = PASSWORD_BCRYPT)
    {
        return password_hash($string, $method);
    }

    public static function comparePassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public static function getToken($string, $method = PASSWORD_BCRYPT)
    {
        return password_hash($string, $method);
    }
}
