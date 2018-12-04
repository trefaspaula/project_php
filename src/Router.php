<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 20.11.2018
 * Time: 11:12
 */

namespace Framework;
class Router
{
    protected $routes;

    function __construct($routes)
    {
        $this->routes = $routes;
    }

    function getClass(string $key)
    {
        $users = [1 => "Pavel",
            2 => "Ion"];
        $controller = $this->routes[$key]['controller'];
        if ($controller == 'UserController') {
            $controller = "App\\Controllers\\$controller";
            //$controllerObject = new $controller($users);
        }
        return $controller;
    }

    function classificationsUrl()
    {

        preg_match('/\d+/', $_SERVER['REQUEST_URI'], $id);
        $queryString = $_SERVER['QUERY_STRING'];
        if ($id != null && $queryString == null) {
            $this->validationDynamicRoutes($id[0]);
        } else {
            if ($id != null && $queryString != null)
                $this->validationQueryRoutes($queryString, $id[0]);

            else
                $this->validationStaticRoutes();
        }

    }

    function validationDynamicRoutes(int $id)
    {
        $string = $_SERVER['REQUEST_URI'];
        $string = str_replace($id, "{id}", $string);

        if (array_key_exists($string, $this->routes)) {
            $controllerObject = $this->getClass($string);
            $action = $this->routes[$string]['action'];
            $this->callController($controllerObject, $action, $string);
            //$controllerObject->{$action}($id);
        } else {
            echo "Invalid URL";
        }
    }

    function validationQueryRoutes(string $queryString, int $id)
    {
        $string = $_SERVER['REQUEST_URI'];
        $string = str_replace($id, "{id}", $string);
        if (array_key_exists($string, $this->routes)) {
            $controllerObject = $this->getClass($string);

            $action = $this->routes[$string]['action'];
            $this->callController($controllerObject, $action, $string);
            // $controllerObject->{$action}($id, $queryString);
        } else {
            echo "Invalid URL";
        }
    }

    function validationStaticRoutes()
    {
        if (array_key_exists($_SERVER['REQUEST_URI'], $this->routes)) {

            $controllerObject = $this->getClass($_SERVER['REQUEST_URI']);
            $action = $this->routes[$_SERVER['REQUEST_URI']]['action'];
            $this->callController($controllerObject, $action, $_SERVER['REQUEST_URI']);
            // $controllerObject->{$action}();
        } else {
            echo "Invalid URL";
        }
    }

    private function checkGuard(string $route): void
    {
        if (isset($this->routes[$route]['guard'])) {
            $guard=$this->routes[$route]['guard'];
            $guard = "App\\Guards\\$guard";
            $guardObj=new $guard();
            $guardObj->handle();

        }
    }

    public function callController(string $controller, string $action, string $url): void
    {
        $this->checkGuard($url);
        $controller = "\\App\\Controllers\\" . $controller;
        $controller = new $controller;
        $controller->{$action}();
    }


}


