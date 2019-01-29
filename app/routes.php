<?php
$routes = [
    '/login/'               => ['controller' => 'LoginController',
        'action'     => 'goToLoginPage'],
    '/login/auth/'          => ['controller' => 'LoginController',
        'action'     => 'login'],
    '/register/'            => ['controller' => 'LoginController',
        'action'     => 'goToRegisterPage'],
    '/signin/'            => ['controller' => 'LoginController',
        'action'     => 'register']
];