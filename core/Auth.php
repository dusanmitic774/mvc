<?php

use models\User;

class Auth
{
    // checks if user is logged in
    public static function check()
    {
        if (Session::exists('user_session')) {
            return true;
        }

        return false;
    }

    // gets the logged in user
    public static function user()
    {
        if (self::check()) {
            $user = new User();

            return $user->select()->find(Session::get('user_session'))->first();
        }

        return '';
    }
}