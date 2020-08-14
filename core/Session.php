<?php

class Session
{
    public static function exists($name)
    {
        if (isset($_SESSION[$name]) && ! empty($_SESSION[$name])) {
            return true;
        }

        return false;
    }

    public static function set($name, $value)
    {
        if ( ! (self::exists($name))) {
            $_SESSION[$name] = $value;

            return true;
        }

        return false;
    }

    public static function get($name)
    {
        if (self::exists($name)) {
            return $_SESSION[$name];
        }

        return false;
    }

    public static function delete($name)
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);

            return true;
        }

        return false;
    }
}