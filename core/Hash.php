<?php

class Hash
{
    public static function password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify($password, $hashed_password)
    {
        if (password_verify($password, $hashed_password)) {
            return true;
        }

        return false;
    }
}