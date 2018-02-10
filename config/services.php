<?php

/**
 * @var \DI\Container $container
 */

$container->set('libs.router', \DI\object(\Libs\Router::class));
$container->set('libs.view', \DI\object(\Libs\View::class));
$container->set('libs.response.response', \DI\object(\Libs\Response\Response::class));
$container->set('libs.response.json.response', \DI\object(\Libs\Response\JsonResponse::class));