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

    function getController(string $key)
    {
        $controller = $this->routes[$key]['controller'];
        $controller = "App\\Controllers\\$controller";

        return $controller;
    }

    function getUrlType()
    {

        preg_match('/\d+/', $_SERVER['REQUEST_URI'], $id);
        $queryString = $_SERVER['QUERY_STRING'];
        if ($id != null && $queryString == null) {
            $this->validateDynamicRoutes($id[0]);
        } else {
            if ($id != null && $queryString != null) {
                $this->validateQueryRoutes($queryString, $id[0]);
            }
            else
                $this->validateStaticRoutes();

        }

    }

    function validateDynamicRoutes(int $id)
    {
        $string = $_SERVER['REQUEST_URI'];
        $string = str_replace($id, "{id}", $string);
        $this->validateCall($string, $id);
    }

    function validateQueryRoutes(string $queryString, int $id)
    {
        $string = $_SERVER['REQUEST_URI'];
        var_dump("query string");
    }

    function validateStaticRoutes()
    {
        $this->validateCall($_SERVER['REQUEST_URI'],null);
    }

    private function checkGuard(string $route): void
    {
        if (isset($this->routes[$route]['guard'])) {
            $guard = $this->routes[$route]['guard'];
            $guard = "App\\Guards\\$guard";
            $guardObj = new $guard();
            $guardObj->handle();

        }
    }

    public function callController(string $controller, string $action, string $url, ?int $param): void
    {
        $this->checkGuard($url);
        $controller = new $controller;
        if ($param == null)
            $controller->{$action}();
        else
            $controller->{$action}($param);

    }

    /**
     * @param $string
     */
    private function validateCall(string $string, ?int $id): ?string
    {
        if (array_key_exists($string, $this->routes)) {
            $controllerObject = $this->getController($string);
            $action = $this->routes[$string]['action'];
            if ($id == null)
                $this->callController($controllerObject, $action, $string, null);
            else
                $this->callController($controllerObject, $action, $string, $id);
        } else {
            var_dump("Invalid URL");
        }
        return null;
    }


}


