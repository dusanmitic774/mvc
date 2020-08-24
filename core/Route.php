<?php

class Route
{
    public static $routes = [];
    public static $named_routes = [];

    public static function get($route, $controller_and_action)
    {
        self::addRoute('GET', $route, $controller_and_action);
    }

    public static function post($route, $controller_and_action)
    {
        self::addRoute('POST', $route, $controller_and_action);

    }

    // Adds a route in $routes based on method (POST/GET)
    private static function addRoute($method, $route, $controller_and_action)
    {
        self::$routes[$method][$route] = self::setControllerAndAction($route, $controller_and_action);
    }

    // Returns an array where controllers is the key and action is value
    // If rules dont match ends script with message
    private static function setControllerAndAction($route, $controller_and_action)
    {
        // looks for this pattern: UsersController@index    (NameController@function)
        if (preg_match('/([a-zA-Z0-9]*)Controller@([a-zA-Z0-9]*)/', $controller_and_action, $matches)) {
            $controller = ( ! empty($matches[1])) ? 'controllers\\' . $matches[1] . 'Controller' : 'controllers\HomeController';
            $action     = ( ! empty($matches[2])) ? $matches[2] : 'index';

            return [
                'controller' => $controller,
                'action'     => $action,
            ];
        } else {
            die('Invalid syntax');
        }
    }

    // executes method based on url
    public static function run($method, $url)
    {
        $params = [];
//        $flag   = true;

        if ( ! empty(self::$routes[$method])) {
            foreach (self::$routes[$method] as $route => $controller_and_action) {
                $params = self::routeMatches($route, $url);
                if ($params !== false) {

                    $controller = new self::$routes[$method][$route]['controller'];
                    $action     = self::$routes[$method][$route]['action'];

                    if (method_exists($controller, $action)) {
                        call_user_func_array([new $controller(), $action], $params);

                        return true;
//                        $flag = false;
                    } else {
                        echo('Method doesnt exist.');
                    }
                }
            }
        }

        if ($params === false) {
            http_response_code(404);
            echo 'Page does exist';
        }

        return false;
    }

    // Checks if url matches with route
    private static function routeMatches($route, $url)
    {
        $params = [];

        $url = explode('/', $url);
        array_shift($url);
        $route = explode('/', $route);
        array_shift($route);

        if (sizeof($url) == sizeof($route)) {
            for ($i = 0; $i < sizeof($url); $i++) {
                if ( ! ($url[$i] == $route[$i]) && ! preg_match('/{[a-zA-Z0-9]*}/', $route[$i])) {
                    return false;
                } elseif (preg_match('/{[a-zA-Z0-9]*}/', $route[$i])) {
                    array_push($params, $url[$i]);
                }
            }
        } else {
            return false;
        }

        return $params;
    }
}
