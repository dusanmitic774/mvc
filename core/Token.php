<?php

class Token
{
    private const TOKEN = 'token';

    public static function set()
    {
        Session::set(self::TOKEN, md5(uniqid(rand(), true)));

        if (Session::exists(self::TOKEN)) {
            return Session::get(self::TOKEN);
        }

        return false;
    }

    public static function check($token)
    {
        if (Session::get(self::TOKEN) == $token) {
            Session::delete(self::TOKEN);

            return true;
        } else {
            return false;
        }
    }
}