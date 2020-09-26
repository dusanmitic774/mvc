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
            return $_POST[$input];
        } elseif (isset($_GET[$input])) {
            return $_GET[$input];
        }

        return '';
    }

    public static function setPostData($data)
    {
        if ( ! empty($data)) {
            foreach ($data as $key => $value) {
                if ($key != 'token') {
                    Session::set('postData-' . $key, $value);
                }
            }
        }
    }

    public static function postData($field)
    {
        if (Session::exists('postData-' . $field)) {
            $data = Session::get('postData-' . $field);
            Session::delete('postData-' . $field);

            return $data;
        }

        return '';
    }
}
