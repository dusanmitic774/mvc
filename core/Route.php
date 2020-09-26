<?php

class Route extends Routes
{
    public static function get(string $route, string $controller_and_action)
    {
        $getRoutes = self::getInstance();
        $getRoutes->addRoute('GET', $route, $controller_and_action);
        return $getRoutes;
    }

    public static function post(string $route, string $controller_and_action)
    {
        $postRoutes = self::getinstance();
        $postRoutes->addroute('POST', $route, $controller_and_action);
        return $postRoutes;
    }


    // executes method based on url
    public static function run(string $method, string $url)
    {
        $params = [];
        $router = self::getInstance();
        $methodRoutes = strtolower($method) . 'Routes';
        $routes = $router->$methodRoutes();

        if (!empty($routes)) {
            foreach ($routes as $route => $controller_and_action) {
                $params = self::routeMatches($route, $url);
                if ($params !== false) {
                    $controller = new $routes[$route]['controller'];
                    $action     = $routes[$route]['action'];

                    if (method_exists($controller, $action)) {
                        call_user_func_array([new $controller(), $action], $params);

                        return true;
                    } else {
                        var_dump($url);
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
    private static function routeMatches(string $route, string $url)
    {
        $params = [];

        $url = explode('/', $url);
        array_shift($url);
        $route = explode('/', $route);
        array_shift($route);

        if (sizeof($url) == sizeof($route)) {
            for ($i = 0; $i < sizeof($url); $i++) {
                if (! ($url[$i] == $route[$i]) && ! preg_match('/{[a-zA-Z0-9]*}/', $route[$i])) {
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
