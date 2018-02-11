<?php

return [
    'routes' => [

        'show' => [
            'uri' => '/show/{id}',
            'controller' => \App\Controller\IndexController::class,
            'action' => 'show'
        ],
        'edit' => [
            'uri' => '/edit/{id}',
            'controller' => \App\Controller\IndexController::class,
            'action' => 'edit'
        ],
        'create' => [
            'uri' => '/create/',
            'controller' => \App\Controller\IndexController::class,
            'action' => 'create'
        ],
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