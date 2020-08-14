<?php

class Input
{
    public static function exists($input)
    {
        if ($input == 'post') {
            return ! empty($_POST);
        } elseif ($input == 'get') {
            return ! empty($_GET);
        }

        return false;
    }

    public static function get($input)
    {
        if (isset($_POST[$input])) {
            return sanitize($_POST[$input]);
        } elseif (isset($_GET[$input])) {
            return sanitize($_GET[$input]);
        }

        return '';
    }
}
