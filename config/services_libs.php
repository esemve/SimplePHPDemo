<?php

/**
* @var \DI\Container $container
*/

$container->set('libs.router', \DI\object(\Libs\Router::class));

$container->set('libs.config.factory', \DI\object(\Libs\ConfigFactory::class));
$container->set('libs.config', DI\factory(['libs.config.factory', 'create']));

$container->set('libs.view', \DI\object(\Libs\View::class)
->constructor(
    $container->get('libs.router')
));

$container->set('libs.database', \DI\object(\Libs\Database::class)
->constructor(
    $container->get('libs.config')
));
$container->set('libs.response.response', \DI\object(\Libs\Response\Response::class));
$container->set('libs.response.json.response', \DI\object(\Libs\Response\JsonResponse::class));