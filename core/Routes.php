<?php

class Routes
{
    private static $instance = null;
    private static $lastAddedRoute;
    private static $lastAddedMethod;
    private $getRoutes = [];
    private $postRoutes = [];
    public static $namedRoutes;

    public function getRoutes()
    {
        return $this->getRoutes;
    }

    public function postRoutes()
    {
        return $this->postRoutes;
    }

    public static function getInstance()
    {
        if (! isset(self::$instance)) {
            self::$instance = new Routes();
        }
        
        return self::$instance;
    }

    public function addRoute(string $method, string $route, string $controller_and_action): void
    {
        if (strtoupper($method) == 'GET') {
            $this->getRoutes[$route] = $this->setControllerAndAction($controller_and_action);
            self::$lastAddedRoute = $route;
            self::$lastAddedMethod = 'get';
        } elseif (strtoupper($method) == 'POST') {
            $this->postRoutes[$route] = $this->setControllerAndAction($controller_and_action);
            self::$lastAddedRoute = $route;
            self::$lastAddedMethod = 'post';
        }
    }


    private function setControllerAndAction(string $controller_and_action)
    {
        // looks for this pattern: UsersController@index    (NameController@function)
        if (preg_match('/([a-zA-Z0-9]*)Controller@([a-zA-Z0-9]*)/', $controller_and_action, $matches)) {
            $controller = (! empty($matches[1])) ? 'controllers\\' . $matches[1] . 'Controller' : 'controllers\HomeController';
            $action     = (! empty($matches[2])) ? $matches[2] : 'index';

            return [
                'controller' => $controller,
                'action'     => $action,
            ];
        } else {
            die('Invalid syntax');
        }
    }

    public function name($routeName)
    {
        $method = self::$lastAddedMethod;
        if (!empty($method)) {
            $lastAddedRoute = self::$lastAddedRoute;
            if (preg_match('/{[a-zA-Z0-9]*}/', self::$lastAddedRoute)) {
                $lastAddedRoute = preg_replace('/{[a-zA-Z0-9]*}/', '', self::$lastAddedRoute);
            }
            self::$namedRoutes[$routeName] = $lastAddedRoute;
        }
    }

    public static function route($routeName)
    {
        foreach (self::$namedRoutes as $namedRoute => $route) {
            if ($namedRoute == $routeName) {
                return $route;
            }
        }
    }
}
