<?php

return [
    'routes' => [
        'index2' => [
            'uri' => '/test/{alma}',
            'controller' => 'test',
            'action' => 'index2'
        ],
        'sajt' => [
            'uri' => '/valami/',
            'controller' => 'aaa',
            'action' => 'action'
        ]
    ],

    'default' => [
        'controller' => 'valami',
        'action' => 'index'
    ],
    'error404' => [
        'controller' => 'akarmi',
        'action' => 'error404'
    ],

];