<?php
$routes = ['/user/{id}' => ['controller' => 'UserController',
    'action' => 'show', 'guard' => 'Authenticated']
];