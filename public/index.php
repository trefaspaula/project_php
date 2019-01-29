<?php

require __DIR__ . '/../vendor/autoload.php';

require_once "../app/config.php";
require_once "../src/Router.php";
require_once "../app/routes.php";

ini_set("error_log", __DIR__ . "/../logs/error.log");
error_reporting(E_ALL);
ini_set("display_errors", 0);
Tracy\Debugger::enable(Tracy\Debugger::PRODUCTION);

if ($config["env"] == "dev") {
    ini_set("display_errors", 1);
    Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT);
}

function bd($data)
{
    bdump($data);
}

function dd($data)
{
    dump($data);
    die();
}

$router = new Framework\Router($routes);
$router->getUrlType();
