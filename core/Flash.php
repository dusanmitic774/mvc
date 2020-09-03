<?php

class Flash
{
    // used for single message
    public static function msg($name, $string = '')
    {
        if (Session::exists($name)) {
            $msg = Session::get($name);
            Session::delete($name);

            return $msg;
        } else {
            Session::set($name, $string);
        }
    }

    // used for validation errors
    public static function errors($errors)
    {
        foreach ($errors as $field => $messages) {
            Flash::msg($field, $messages[0]);
        }
    }
}