<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../libs/HelperFunctions.php';

$router = new \Libs\Router();
$router->setRouteArray(require(__DIR__.'/../config/routes.php'));

$resolvedRoute = $router->resolve($_SERVER['REQUEST_URI']);
dd($resolvedRoute);
