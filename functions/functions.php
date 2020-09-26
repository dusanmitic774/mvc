<?php

function redirect($url)
{
    header('location: ' . BASE_URL . $url);
}

function esc($string)
{
    return htmlentities($string, ENT_QUOTES, 'UTF-8');
}

function route($routeName)
{
    foreach (Routes::$namedRoutes as $namedRoute => $route) {
        if ($namedRoute == $routeName) {
            return $route;
        }
    }
}
