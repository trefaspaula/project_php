<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 20.11.2018
 * Time: 11:12
 */

class Router
{
    protected $routes;

    function __construct($routes)
    {

    }
    function validationUrl(){
        if(isset($_SERVER["REQUEST_URI"])){
           $controller= $this->routes[$_SERVER['REQUEST_URI']]['controller'];
           $controllerObject=new $controller();
            $action = $this->routes[$_SERVER['REQUEST_URI']['action']];
            $controllerObject->{$action}();

        }
    }
}