<?php

class Redirect
{
    public $data = [];

    public static function to($url, $data)
    {

        header('location: ' . BASE_URL . '/' . $url);
    }
}