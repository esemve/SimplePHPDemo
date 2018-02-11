<?php

return [
    'routes' => [

        'show' => [
            'uri' => '/show/{id}',
            'controller' => \App\Controller\IndexController::class,
            'action' => 'show'
        ]
    ],

    'default' => [
        'controller' => \App\Controller\IndexController::class,
        'action' => 'index'
    ],
    'error404' => [
        'controller' => \App\Controller\ErrorController::class,
        'action' => 'error404'
    ],
];