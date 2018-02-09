<?php

return [
    'routes' => [

        'index2' => [
            'uri' => '/test/*',
            'controller' => \App\Controller\IndexController::class,
            'action' => 'index2'
        ]

    ],

    'default' => [
        'controller' => \App\Controller\IndexController::class,
        'action' => 'index'
    ],
    'error404' => [
        'controller' => \App\Controller\ErrorController::class,
        'action' => 'index'
    ],
];