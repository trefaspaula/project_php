<?php
/**
 * Created by PhpStorm.
 * User: Paula
 * Date: 27.11.2018
 * Time: 13:41
 */

namespace Framework;
class Controller
{
    private $twig;

    function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../app/views');
        $this->twig = new \Twig_Environment($loader, array(
            'cache' => __DIR__ . '/../storage/cache/views',
        ));

    }

    function view(string $viewFile, array $params)
    {
        echo $this->twig->render($viewFile, $params);
    }
}