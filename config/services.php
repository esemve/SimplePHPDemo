<?php

require_once __DIR__.'/services_libs.php';

$container->set('app.repository.blog',
    \DI\object(\App\Repository\BlogRepository::class)->constructor(
        $container->get('libs.database')
    )
);